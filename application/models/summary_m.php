<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summary_m extends CI_Model {

    /**
     * Sanitize legacy WHERE fragments used by filters/export.
     * Allows only simple LIKE / AND conditions on known column names.
     */
    function sanitizeWhere($where)
    {
        $where = trim((string) $where);
        if ($where === '' || $where === '1') {
            return '1';
        }
        if (preg_match('/[;]|--|\/\*|\*\//', $where)) {
            return '1';
        }
        if (!preg_match('/^[a-zA-Z0-9_`.%!\\\\\s\'\"=<>,()-]+$/u', $where)) {
            return '1';
        }
        return $where;
    }

    private function parseDtParams()
    {
        $CI =& get_instance();
        $draw = (int) $CI->input->get_post('draw');
        $start = max(0, (int) $CI->input->get_post('start'));
        $length = (int) $CI->input->get_post('length');
        if ($length === 0) {
            $length = 25;
        }
        if ($length < 0) {
            $length = -1;
        }

        $search = '';
        $search_arr = $CI->input->get_post('search');
        if (is_array($search_arr) && isset($search_arr['value'])) {
            $search = trim($search_arr['value']);
        }

        $order_col = 0;
        $order_dir = 'desc';
        $order = $CI->input->get_post('order');
        if (is_array($order) && isset($order[0]['column'])) {
            $order_col = (int) $order[0]['column'];
            $order_dir = isset($order[0]['dir']) ? $order[0]['dir'] : 'desc';
        }

        $where = $this->sanitizeWhere($CI->input->get_post('where'));

        return compact('draw', 'start', 'length', 'search', 'order_col', 'order_dir', 'where');
    }

    function getDtParams()
    {
        return $this->parseDtParams();
    }

    /* -------------------- PCR -------------------- */

    private function pcrBaseFrom()
    {
        return " FROM replacement r
            LEFT JOIN unit u ON r.id_unit = u.id_unit
            LEFT JOIN commod cm ON r.id_mod = cm.id_mod
            LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
            LEFT JOIN project p ON u.id_project = p.id_project
            LEFT JOIN comp c ON cm.id_comp = c.id_comp ";
    }

    private function pcrWhereSql($where, $search)
    {
        $sql = " WHERE (" . $where . ") ";
        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $sql .= " AND (
                p.kode_project LIKE '%{$esc}%'
                OR m.manufacture LIKE '%{$esc}%'
                OR m.model_no LIKE '%{$esc}%'
                OR u.unit_no LIKE '%{$esc}%'
                OR c.comp_desc LIKE '%{$esc}%'
                OR r.wo_no LIKE '%{$esc}%'
                OR r.wo_status LIKE '%{$esc}%'
                OR r.comp_cond LIKE '%{$esc}%'
            ) ";
        }
        return $sql;
    }

    function countPcr($where, $search = '')
    {
        $where = $this->sanitizeWhere($where);
        $sql = "SELECT COUNT(*) AS cnt " . $this->pcrBaseFrom() . $this->pcrWhereSql($where, $search);
        $row = $this->db->query($sql)->row();
        return $row ? (int) $row->cnt : 0;
    }

    function getLatestHmMap($unit_ids)
    {
        $map = array();
        $unit_ids = array_values(array_unique(array_filter(array_map('intval', (array) $unit_ids))));
        if (empty($unit_ids)) {
            return $map;
        }
        $ids = implode(',', $unit_ids);
        $rows = $this->db->query(
            "SELECT h.id_unit, h.hm_unit
             FROM hm h
             INNER JOIN (
                SELECT id_unit, MAX(date_hm) AS MaxDate
                FROM hm
                WHERE id_unit IN ({$ids})
                GROUP BY id_unit
             ) x ON h.id_unit = x.id_unit AND h.date_hm = x.MaxDate
             WHERE h.id_unit IN ({$ids})"
        )->result();
        foreach ($rows as $row) {
            $map[(int) $row->id_unit] = (float) $row->hm_unit;
        }
        return $map;
    }

    function getPcrPage($where, $search, $start, $length, $order_col, $order_dir)
    {
        $where = $this->sanitizeWhere($where);
        $columns = array(
            'r.id_rep',
            'p.kode_project',
            'm.manufacture',
            'm.model_no',
            'u.unit_no',
            'c.comp_desc',
            'cm.policy',
            'cm.price',
            'r.life_percent',
            'r.comp_life',
            'r.comp_cond',
            'r.hm_rep',
            'r.wo_no',
            'r.wo_date',
            'r.wo_status',
            'r.wo_end_date',
            'r.comp_hour',
            'r.last_hm_rep',
            'r.last_rep_date',
            'r.remarks',
            'r.id_rep'
        );
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'r.id_rep';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT
                r.id_rep, r.id_unit, r.id_mod, r.wo_no, r.wo_date, r.wo_status, r.wo_end_date,
                r.comp_hour, r.last_hm_rep, r.last_rep_date, r.comp_cond, r.remarks,
                r.life_percent, r.comp_life, r.hm_rep,
                p.kode_project, m.manufacture, m.model_no, u.unit_no, c.comp_desc,
                cm.policy, cm.price
            " . $this->pcrBaseFrom() . $this->pcrWhereSql($where, $search) . "
            ORDER BY {$order_by} {$order_dir} ";

        if ($length > 0) {
            $sql .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }

        $rows = $this->db->query($sql)->result();
        $unit_ids = array();
        foreach ($rows as $row) {
            $unit_ids[] = $row->id_unit;
        }
        $hm_map = $this->getLatestHmMap($unit_ids);
        $wh_map = $this->getWhDayMap($unit_ids);

        foreach ($rows as $row) {
            $policy = (float) $row->policy;
            $wh = isset($wh_map[(int) $row->id_unit]) ? $wh_map[(int) $row->id_unit] : 0;
            $row->wh_day = round($wh, 1);

            if ($row->wo_status === 'OPEN') {
                $hm_now = isset($hm_map[(int) $row->id_unit]) ? $hm_map[(int) $row->id_unit] : 0;
                $comp_life = ($hm_now - (float) $row->last_hm_rep) + (float) $row->comp_hour;
                $life = ($policy > 0) ? ($comp_life / $policy) * 100 : 0;
                $row->hm_now = $hm_now;
                $row->comp_life_calc = $comp_life;
                $row->life_percent_calc = $life;
                if ($wh > 0) {
                    $forecast = (int) round(($policy - $comp_life) / $wh);
                    $row->next_date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $forecast . ' days'));
                } else {
                    $row->next_date = '';
                }
            } else {
                $row->hm_now = $row->hm_rep;
                $row->comp_life_calc = $row->comp_life;
                $row->life_percent_calc = $row->life_percent;
                $row->next_date = '';
            }
        }

        return $rows;
    }

    function getPcrExportRows($where)
    {
        $where = $this->sanitizeWhere($where);
        $sql = "SELECT r.*, u.unit_no, p.kode_project, m.manufacture, m.model_no,
                c.comp_desc, cm.policy, cm.price, cm.id_mod
            " . $this->pcrBaseFrom() . "
            WHERE (" . $where . ")
            ORDER BY p.kode_project ASC, m.manufacture ASC, c.comp_desc ASC, r.id_rep DESC";
        return $this->db->query($sql)->result_array();
    }

    function getWhDayAvg($id_unit)
    {
        $row = $this->db->query(
            "SELECT AVG(wh_day) AS avg_wh
             FROM hm
             WHERE date_hm <= CURDATE()
               AND date_hm >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
               AND id_unit = " . (int) $id_unit
        )->row();
        return ($row && $row->avg_wh !== null) ? (float) $row->avg_wh : 0;
    }

    function getWhDayMap($unit_ids)
    {
        $map = array();
        $unit_ids = array_values(array_unique(array_filter(array_map('intval', (array) $unit_ids))));
        if (empty($unit_ids)) {
            return $map;
        }
        $ids = implode(',', $unit_ids);
        $rows = $this->db->query(
            "SELECT id_unit, AVG(wh_day) AS avg_wh
             FROM hm
             WHERE date_hm <= CURDATE()
               AND date_hm >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
               AND id_unit IN ({$ids})
             GROUP BY id_unit"
        )->result();
        foreach ($rows as $row) {
            $map[(int) $row->id_unit] = $row->avg_wh !== null ? (float) $row->avg_wh : 0;
        }
        return $map;
    }

    /* -------------------- SOS -------------------- */

    private function sosBaseFrom()
    {
        return " FROM sos s
            LEFT JOIN unit u ON s.id_unit = u.id_unit
            LEFT JOIN commod cm ON s.id_mod = cm.id_mod
            LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
            LEFT JOIN project p ON u.id_project = p.id_project
            LEFT JOIN comp c ON cm.id_comp = c.id_comp ";
    }

    private function sosWhereSql($where, $search)
    {
        $sql = " WHERE (" . $where . ") ";
        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $sql .= " AND (
                p.kode_project LIKE '%{$esc}%'
                OR u.unit_no LIKE '%{$esc}%'
                OR c.comp_desc LIKE '%{$esc}%'
                OR s.lab_no LIKE '%{$esc}%'
                OR s.eval_code LIKE '%{$esc}%'
                OR s.sample_date LIKE '%{$esc}%'
            ) ";
        }
        return $sql;
    }

    function countSos($where, $search = '')
    {
        $where = $this->sanitizeWhere($where);
        $row = $this->db->query("SELECT COUNT(*) AS cnt " . $this->sosBaseFrom() . $this->sosWhereSql($where, $search))->row();
        return $row ? (int) $row->cnt : 0;
    }

    function getSosPage($where, $search, $start, $length, $order_col, $order_dir)
    {
        $where = $this->sanitizeWhere($where);
        $columns = array(
            's.id_sos',
            'p.kode_project',
            's.sample_date',
            'u.unit_no',
            'c.comp_desc',
            's.lab_no',
            's.eval_code',
            's.id_sos'
        );
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 's.id_sos';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT s.*, u.unit_no, p.kode_project, c.comp_desc, m.model_no, cm.id_mod
            " . $this->sosBaseFrom() . $this->sosWhereSql($where, $search) . "
            ORDER BY {$order_by} {$order_dir} ";
        if ($length > 0) {
            $sql .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }
        return $this->db->query($sql)->result();
    }

    function getSosExportRows($where)
    {
        $where = $this->sanitizeWhere($where);
        return $this->db->query(
            "SELECT * " . $this->sosBaseFrom() . "
             WHERE (" . $where . ")
             ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_sos DESC"
        )->result_array();
    }

    /* -------------------- Inspection -------------------- */

    private function inspectionBaseFrom()
    {
        return " FROM inspection s
            LEFT JOIN unit u ON s.id_unit = u.id_unit
            LEFT JOIN commod cm ON s.id_mod = cm.id_mod
            LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
            LEFT JOIN project p ON u.id_project = p.id_project
            LEFT JOIN comp c ON cm.id_comp = c.id_comp ";
    }

    private function inspectionWhereSql($where, $search)
    {
        $sql = " WHERE (" . $where . ") ";
        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $sql .= " AND (
                p.kode_project LIKE '%{$esc}%'
                OR u.unit_no LIKE '%{$esc}%'
                OR c.comp_desc LIKE '%{$esc}%'
                OR s.rating LIKE '%{$esc}%'
                OR s.type LIKE '%{$esc}%'
                OR s.ins_date LIKE '%{$esc}%'
            ) ";
        }
        return $sql;
    }

    function countInspection($where, $search = '')
    {
        $where = $this->sanitizeWhere($where);
        $row = $this->db->query("SELECT COUNT(*) AS cnt " . $this->inspectionBaseFrom() . $this->inspectionWhereSql($where, $search))->row();
        return $row ? (int) $row->cnt : 0;
    }

    function getInspectionPage($where, $search, $start, $length, $order_col, $order_dir)
    {
        $where = $this->sanitizeWhere($where);
        $columns = array(
            's.id_ins',
            'p.kode_project',
            's.ins_date',
            'u.unit_no',
            'c.comp_desc',
            's.ins_hm',
            's.rating',
            's.type'
        );
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 's.id_ins';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT s.*, u.unit_no, p.kode_project, c.comp_desc, m.model_no
            " . $this->inspectionBaseFrom() . $this->inspectionWhereSql($where, $search) . "
            ORDER BY {$order_by} {$order_dir} ";
        if ($length > 0) {
            $sql .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }
        return $this->db->query($sql)->result();
    }

    function getInspectionExportRows($where)
    {
        $where = $this->sanitizeWhere($where);
        return $this->db->query(
            "SELECT * " . $this->inspectionBaseFrom() . "
             WHERE (" . $where . ")
             ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC, s.id_ins DESC"
        )->result_array();
    }

    /* -------------------- Condition -------------------- */

    private function conditionBaseFrom()
    {
        return " FROM `condition` cd
            LEFT JOIN unit u ON cd.id_unit = u.id_unit
            LEFT JOIN commod cm ON cd.id_mod = cm.id_mod
            LEFT JOIN model m ON u.id_model = m.id_model AND cm.id_model = m.id_model
            LEFT JOIN project p ON u.id_project = p.id_project
            LEFT JOIN comp c ON cm.id_comp = c.id_comp ";
    }

    private function conditionWhereSql($where, $search)
    {
        $sql = " WHERE (" . $where . ") ";
        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $sql .= " AND (
                p.kode_project LIKE '%{$esc}%'
                OR u.unit_no LIKE '%{$esc}%'
                OR m.model_no LIKE '%{$esc}%'
                OR c.comp_desc LIKE '%{$esc}%'
                OR cd.condition LIKE '%{$esc}%'
            ) ";
        }
        return $sql;
    }

    function countCondition($where, $search = '')
    {
        $where = $this->sanitizeWhere($where);
        $row = $this->db->query("SELECT COUNT(*) AS cnt " . $this->conditionBaseFrom() . $this->conditionWhereSql($where, $search))->row();
        return $row ? (int) $row->cnt : 0;
    }

    function getConditionPage($where, $search, $start, $length, $order_col, $order_dir)
    {
        $where = $this->sanitizeWhere($where);
        $columns = array(
            'cd.id_cond',
            'p.kode_project',
            'u.unit_no',
            'm.model_no',
            'c.comp_desc',
            'cd.condition'
        );
        // fallback if PK name differs
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'p.kode_project';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT cd.*, u.unit_no, p.kode_project, c.comp_desc, m.model_no
            " . $this->conditionBaseFrom() . $this->conditionWhereSql($where, $search) . "
            ORDER BY {$order_by} {$order_dir} ";
        if ($length > 0) {
            $sql .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }
        return $this->db->query($sql)->result();
    }

    function getConditionExportRows($where)
    {
        $where = $this->sanitizeWhere($where);
        return $this->db->query(
            "SELECT * " . $this->conditionBaseFrom() . "
             WHERE (" . $where . ")
             ORDER BY p.kode_project ASC, u.unit_no ASC, c.comp_desc ASC"
        )->result_array();
    }

    /* -------------------- Cannibal -------------------- */

    function cannibalUnitRemoveSql()
    {
        return "(SELECT u.unit_no FROM kanibal k LEFT JOIN unit u ON k.id_unit=u.id_unit WHERE k.no_ba=ba.no_ba AND k.type='REMOVE' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    function cannibalUnitInstallSql()
    {
        return "(SELECT u.unit_no FROM kanibal k LEFT JOIN unit u ON k.id_unit=u.id_unit WHERE k.no_ba=ba.no_ba AND k.type='INSTALL' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    function cannibalWoRemoveSql()
    {
        return "(SELECT k.wo_no_kanibal FROM kanibal k WHERE k.no_ba=ba.no_ba AND k.type='REMOVE' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    function cannibalWoInstallSql()
    {
        return "(SELECT k.wo_no_kanibal FROM kanibal k WHERE k.no_ba=ba.no_ba AND k.type='INSTALL' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    function cannibalCompSql()
    {
        return "(SELECT k.comp_desc FROM kanibal k WHERE k.no_ba=ba.no_ba AND k.type='REMOVE' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    function cannibalPnSql()
    {
        return "(SELECT k.pn FROM kanibal k WHERE k.no_ba=ba.no_ba AND k.type='REMOVE' ORDER BY k.id_kanibal DESC LIMIT 1)";
    }

    private function cannibalBaseFrom()
    {
        return " FROM ba
            LEFT JOIN project p ON ba.id_project = p.id_project
            LEFT JOIN ba_action a ON ba.id_action = a.id_action ";
    }

    private function cannibalWhereSql($where, $search)
    {
        $sql = " WHERE (" . $where . ") ";
        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $ur = $this->cannibalUnitRemoveSql();
            $ui = $this->cannibalUnitInstallSql();
            $comp = $this->cannibalCompSql();
            $pn = $this->cannibalPnSql();
            $sql .= " AND (
                p.kode_project LIKE '%{$esc}%'
                OR ba.no_ba LIKE '%{$esc}%'
                OR ba.posting_date LIKE '%{$esc}%'
                OR ba.symptom LIKE '%{$esc}%'
                OR ba.status_ba LIKE '%{$esc}%'
                OR a.action LIKE '%{$esc}%'
                OR {$ur} LIKE '%{$esc}%'
                OR {$ui} LIKE '%{$esc}%'
                OR {$comp} LIKE '%{$esc}%'
                OR {$pn} LIKE '%{$esc}%'
            ) ";
        }
        return $sql;
    }

    function countCannibalSummary($where, $search = '')
    {
        $where = $this->sanitizeWhere($where);
        $row = $this->db->query(
            "SELECT COUNT(*) AS cnt " . $this->cannibalBaseFrom() . $this->cannibalWhereSql($where, $search)
        )->row();
        return $row ? (int) $row->cnt : 0;
    }

    function getCannibalSummaryPage($where, $search, $start, $length, $order_col, $order_dir)
    {
        $where = $this->sanitizeWhere($where);
        $ur = $this->cannibalUnitRemoveSql();
        $ui = $this->cannibalUnitInstallSql();
        $wr = $this->cannibalWoRemoveSql();
        $wi = $this->cannibalWoInstallSql();
        $comp = $this->cannibalCompSql();
        $pn = $this->cannibalPnSql();

        $columns = array(
            'ba.id_ba',
            'p.kode_project',
            'ba.posting_date',
            'ba.no_ba',
            'unit_remove',
            'unit_install',
            'pn',
            'comp_desc',
            'ba.symptom',
            'a.action',
            'ba.status_ba',
            'ba.mr_no',
            'ba.pr_no',
            'ba.po_no'
        );
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'ba.id_ba';
        $order_dir = strtolower($order_dir) === 'asc' ? 'ASC' : 'DESC';

        $sql = "SELECT ba.id_ba, ba.no_ba, ba.posting_date, ba.symptom, ba.status_ba,
                ba.mr_no, ba.pr_no, ba.po_no,
                p.kode_project, a.action,
                {$ur} AS unit_remove,
                {$ui} AS unit_install,
                {$wr} AS wo_remove,
                {$wi} AS wo_install,
                {$comp} AS comp_desc,
                {$pn} AS pn
            " . $this->cannibalBaseFrom() . $this->cannibalWhereSql($where, $search) . "
            ORDER BY {$order_by} {$order_dir} ";
        if ($length > 0) {
            $sql .= " LIMIT " . (int) $length . " OFFSET " . (int) $start;
        }
        return $this->db->query($sql)->result();
    }

    function getCannibalSummaryExportRows($where)
    {
        $where = $this->sanitizeWhere($where);
        $ur = $this->cannibalUnitRemoveSql();
        $ui = $this->cannibalUnitInstallSql();
        $wr = $this->cannibalWoRemoveSql();
        $wi = $this->cannibalWoInstallSql();
        $comp = $this->cannibalCompSql();
        $pn = $this->cannibalPnSql();

        return $this->db->query(
            "SELECT ba.no_ba, ba.posting_date, ba.symptom, ba.status_ba,
                ba.mr_no, ba.pr_no, ba.po_no,
                p.kode_project, a.action,
                {$ur} AS unit_remove,
                {$ui} AS unit_install,
                {$wr} AS wo_remove,
                {$wi} AS wo_install,
                {$comp} AS comp_desc,
                {$pn} AS pn
            " . $this->cannibalBaseFrom() . "
             WHERE (" . $where . ")
             ORDER BY p.kode_project ASC, ba.posting_date DESC, ba.id_ba DESC"
        )->result_array();
    }
}
