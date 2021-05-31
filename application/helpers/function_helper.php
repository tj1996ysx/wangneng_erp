<?php
function lx($o, $a = 0) {
    echo "<pre>";
    print_r($o);
    if ($a == '0') {
        die();
    }
}

function showmsg($code, $msg = '', $count = 0, $data = []) {
    $res['code'] = $code;
    $res['count'] = $count;
    $res['msg'] = $msg;
    $res['data'] = $data;
    echo json_encode($res);
}

function getDataTree($rows, $id = 'id', $pid = 'fid', $child = 'child', $root = 0) {
    $tree = array(); // 树  
    if (is_array($rows)) {
        $array = array();
        foreach ($rows as $key => $item) {
            $array[$item[$id]] = & $rows[$key];
        }
        foreach ($rows as $key => $item) {
            $parentId = $item[$pid];
            if ($root == $parentId) {
                $tree[] = &$rows[$key];
            } else {
                if (isset($array[$parentId])) {
                    $parent = &$array[$parentId];
                    $parent[$child][] = &$rows[$key];
                }
            }
        }
    }
    return $tree;
}

function getTree($array, $id = 'id', $fid = 'fid', $pid = 0, $level = 0) {
    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static $list = [];
    foreach ($array as $key => $value) {
        //第一次遍历,找到父节点为根节点的节点 也就是pid=0的节点
        if ($value[$fid] == $pid) {
            //父节点为根节点的节点,级别为0，也就是第一级
            $value['level'] = $level;
            //把数组放到list中
            $list[] = $value;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($array[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            getTree($array, $id, $fid, $value[$id], $level + 1);
        }
    }
    return $list;
}

//根据父id获得子类
function tree($arr, $id, $cid, $parent) {
    static $list = array();
    foreach ($arr as $v) {
        if ($v[$cid] == $id) {
            $list[] = $v;
            if ($v[$parent] > 0) {
                tree($arr, $v[$parent], $cid, $parent);
            }
        }
    }
    return $list;
}

//验证权限
function checkrole($method, $action) {
    $CI = & get_instance();
    if ($CI->session->userdata('admin_user_info')['userid'] == 1) {
        return true;
    }
    $CI->db->select('roleids'); //查询的字段
    $CI->db->from('system_users as a'); //连表的主表
    $CI->db->join('system_users_role as b', 'a.roleid=b.roleid', 'left'); //连接表
    $CI->db->where('a.userid', $CI->session->userdata('admin_user_info')['userid']);
    $res = $CI->db->get()->row_array();
    $CI->db->select('*');
    $CI->db->where('model', $method);
    $CI->db->where('action', $action);
    $CI->db->where_in('id', explode(",", $res['roleids']));
    $result = $CI->db->get('system_menu')->row_array();
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function getmenu() {
    $CI = & get_instance();
    $CI->db->select('roleids'); //查询的字段
    $CI->db->from('system_users as a'); //连表的主表
    $CI->db->join('system_users_role as b', 'a.roleid=b.roleid', 'left'); //连接表
    $CI->db->where('a.userid', $CI->session->userdata('admin_user_info')['userid']);
    $res = $CI->db->get()->row_array();
    $CI->db->select('*');
    if ($CI->session->userdata('admin_user_info')['userid'] != 1) {
        $CI->db->where_in('id', explode(",", $res['roleids']));
    }
    $CI->db->where('status=1');
    $result = getDataTree($CI->db->order_by('sort', 'desc')->get('system_menu')->result_array(),'id','parent');
    return $result;
}
function doupload($filepath = "",$allowed_types="gif|jpg|png") {
    $config['upload_path'] = "data/upload/".$filepath."/".date("Ymd");
    $config['allowed_types'] = $allowed_types;
    $config['file_name'] =  date("His").rand(100000, 999999);
    if (!file_exists($config['upload_path'])) {
        mkdir($config['upload_path'], 0777, true);
    }
    $CI = & get_instance();
    $CI->load->library('upload', $config);
    if (!$CI->upload->do_upload('file')) {
        $error = array('error' => $CI->upload->display_errors());
        echo json_encode(['code' => 1, 'data' => $error]);
    } else {
        $data = array('upload_data' => $CI->upload->data());
        echo json_encode(['code' => 0, 'data' => $data]);
    }
}

?>
