<?php
	/**
	 * Description of data
	 *
	 * @author Victor Rivera
	 */

	include_once "config.class.php";
	include_once "tables/employee.class.php";
	include_once "tables/emppost.class.php";
	include_once "tables/empclinic.class.php";

	class data {

	    function getClinic($cli = 0){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $result = array();

	        $where = ($cli == 0) ? "" : " and cli_id = {$cli} ";
	        $query = "select cli_id, cli_name from {$config->db_name}.clinic
	        where cli_id > 1 and cli_active = 1 {$where} order by cli_name";

	        $ps = $conn->prepare($query);
	        $execute = $ps->execute();
	        $ps->bind_result($cli_id, $cli_name);

	        if($execute == FALSE){
	            return $ps->error();
	        }
	        else{
	            while($ps->fetch()){
	                $string = $cli_id."*".$cli_name;
	                array_push($result, $string);

	            }

	            return $result;
	        }

	        $ps->close();
	        $conn->close();

	    }

	    function getPost($post = 0){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $result = array();

	        $where = ($post == 0) ? "" : " where pst_id = {$post} ";
	        $query = "select pst_id, pst_name from {$config->db_name}.post {$where} order by pst_name";

	        $ps = $conn->prepare($query);
	        $execute = $ps->execute();
	        $ps->bind_result($pst_id, $pst_name);

	        if($execute == FALSE){
	            return $ps->error();
	        }
	        else{
	            while($ps->fetch()){
	                $string = $pst_id."*".$pst_name;
	                array_push($result, $string);

	            }

	            return $result;
	        }

	        $ps->close();
	        $conn->close();

	    }

	    function insertEmployee(employee $employee){

	            $config = new config();
	            $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	            $query = "insert into {$config->db_name}.employee(pat_id, emp_lastname, emp_surename, emp_name, emp_complete, emp_abbr, emp_cel, emp_tel, emp_email, ade_id, emp_active)
	                      values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	            $pat_id = "";
	            $emp_lastname = $employee->getEmpLastName();
	            $emp_surename = $employee->getEmpSureName();
	            $emp_name = $employee->getEmpName();
	            $emp_complete = $employee->getEmpComplete();
	            $emp_abbr = $employee->getEmpAbbr();
	            $emp_cel = $employee->getEmpCel();
	            $emp_tel = $employee->getEmpTel();
	            $emp_email = $employee->getEmpEmail();
	            $ade_id = $employee->getAdeId();
	            $emp_active = $employee->getEmpActive();

	            $ps = $conn->prepare($query);
	            $ps->bind_param("sssssssssii", $pat_id, $emp_lastname, $emp_surename, $emp_name, $emp_complete, $emp_abbr, $emp_cel, $emp_tel, $emp_email, $ade_id, $emp_active);
	            $execute = $ps->execute();

	            if($execute == FALSE){
	                return "ERROR";
	            }
	            else{

	                $key = $ps->insert_id;
	                return $key;

	            }

	            $ps->close();
	            $conn->close();

	    }

	    function insertEmpPost(emppost $emppost){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "insert into {$config->db_name}.emppost(emp_id, pst_id, usr_id, eps_date, eps_active)
	                  values(?,?,?,?,?)";

	        $emp_id = $emppost->getEmpId();
	        $pst_id = $emppost->getPstId();
	        $usr_id = $emppost->getUsrId();
	        $eps_date = $emppost->getEpsDate();
	        $eps_active = $emppost->getEpsActive();

	        $ps = $conn->prepare($query);
	        $ps->bind_param("iiisi", $emp_id, $pst_id, $usr_id, $eps_date, $eps_active);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }
	        else{

	            return "OK";

	        }

	        $ps->close();
	        $conn->close();

	    }

	    function insertEmpClinic(empclinic $empclinic){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "insert into {$config->db_name}.empclinic(cli_id, emp_id, spc_id)
	                  values(?,?,?)";

	        $cli_id = $empclinic->getCliId();
	        $emp_id = $empclinic->getEmpId();
	        $spc_id = $empclinic->getSpcId();

	        $ps = $conn->prepare($query);
	        $ps->bind_param("iii", $cli_id, $emp_id, $spc_id);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }
	        else{

	            return "OK";

	        }

	        $ps->close();
	        $conn->close();

	    }

	    function updateEmpClinic(empclinic $empclinic){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "update {$config->db_name}.empclinic set
	                  spc_id = ?
	                  where emp_id = ?";

	        $emp_id = $empclinic->getEmpId();
	        $spc_id = $empclinic->getSpcId();

	        $ps = $conn->prepare($query);
	        $ps->bind_param("ii", $spc_id, $emp_id);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }
	        else{

	            return "OK";

	        }

	        $ps->close();
	        $conn->close();

	    }

	    function getEmployeeInfo($empid){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $array = array();

	        $query = "select emp.emp_complete, emp.emp_tel, emp.emp_cel, emp.emp_email, emp.emp_surename, emp.emp_lastname, emp.emp_name, cli.cli_name, cli.cli_id
	                  from {$config->db_name}.employee emp
	                  left join ({$config->db_name}.empclinic ecl
	                             left join {$config->db_name}.clinic cli
	                             on ecl.cli_id = cli.cli_id)
	                  on emp.emp_id = ecl.emp_id
	                  where emp.emp_id = ?
	                  order by cli.cli_id";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $empid);
	        $ps->execute();
	        $ps->bind_result($emp_complete, $emp_tel, $emp_cel, $emp_email, $emp_surename, $emp_lastname, $emp_name, $cli_name, $cli_id);

	        while($ps->fetch()){

	            array_push($array, $emp_complete."*".$emp_tel."*".$emp_cel."*".$emp_email."*".$emp_surename."*".$emp_lastname."*".$emp_name."*".$cli_name."*".$cli_id);


	        }

	        return $array;

	        $ps->close();
	        $conn->close();

	    }

	    function empList($eps_active = 1, $active = 1, $active2 = 0){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $array = array();

	        $query = "SELECT tbl.* FROM ((SELECT res2 . *
	                    FROM (

	                    SELECT res . *
	                    FROM (

	                    SELECT emp.emp_id, emp.emp_complete, emp.emp_email, eps.eps_active, eps.pst_id
	                    FROM {$config->db_name}.employee emp
	                    LEFT JOIN {$config->db_name}.emppost eps ON emp.emp_id = eps.emp_id
	                    WHERE emp.emp_active = {$active}
	                    AND emp.emp_id != 1
	                    ORDER BY eps.eps_date DESC
	                    ) AS res
	                    GROUP BY res.emp_id, res.pst_id
	                    ) AS res2
	                    WHERE res2.eps_active = {$eps_active}
	                    )
	                   UNION (
	                    SELECT res2 . *
	                    FROM (

	                    SELECT res . *
	                    FROM (

	                    SELECT emp.emp_id, emp.emp_complete, emp.emp_email, eps.eps_active, eps.pst_id
	                    FROM {$config->db_name}.employee emp
	                    LEFT JOIN {$config->db_name}.emppost eps ON emp.emp_id = eps.emp_id
	                    WHERE emp.emp_active = {$active2}
	                    AND emp.emp_id != 1
	                    ORDER BY eps.eps_date DESC
	                    ) AS res
	                    GROUP BY res.emp_id, res.pst_id
	                    ) AS res2
	                    WHERE res2.eps_active = {$eps_active}
	                    )
	                    UNION(
	                    SELECT res2 . *
	                    FROM (

	                    SELECT res . *
	                    FROM (

	                    SELECT emp.emp_id, emp.emp_complete, emp.emp_email, eps.eps_active, eps.pst_id
	                    FROM {$config->db_name}.employee emp
	                    LEFT JOIN {$config->db_name}.emppost eps ON emp.emp_id = eps.emp_id
	                    WHERE emp.emp_active = {$active}
	                    AND emp.emp_id != 1
	                    ORDER BY eps.eps_date DESC
	                    ) AS res
	                    GROUP BY res.emp_id, res.pst_id
	                    ) AS res2
	                    WHERE res2.eps_active IS NULL
	                    )) as tbl
						GROUP BY tbl.emp_complete
	                    ORDER BY tbl.emp_complete";

	        $ps = $conn->prepare($query);
	        $ps->execute();
	        $ps->bind_result($emp_id, $emp_complete, $emp_email, $eps_ac, $pst_id);

	        while($ps->fetch()){
	            array_push($array, $emp_id."*".$emp_complete."*".$emp_email);
	        }
	        return $array;

	        $ps->close();
	        $conn->close();


	    }

	    function getEmpPosts($empid){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $array = array();

	        $query = "SELECT res2.pst_id, res2.pst_name, res2.eps_active
	                FROM (

	                    SELECT res.pst_id, res.pst_name, res.eps_active
	                    FROM (

	                        SELECT pst.pst_id, pst.pst_name, eps.eps_active
	                        FROM {$config->db_name}.emppost eps
	                        LEFT JOIN {$config->db_name}.post pst ON eps.pst_id = pst.pst_id
	                        WHERE eps.emp_id = ?
	                        ORDER BY eps.eps_date DESC
	                    ) AS res
	                    GROUP BY res.pst_name
	                ) AS res2
	                WHERE res2.eps_active";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $empid);
	        $ps->execute();
	        $ps->bind_result($pst_id, $pst_name, $eps_active);

	        while($ps->fetch()){
	            array_push($array, $pst_name."*".$pst_id);
	        }

	        return $array;

	        $ps->close();
	        $conn->close();


	    }

	    function getLastEmpPosts($empid){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $array = array();

	        $query = "SELECT res.pst_id, res.pst_name, res.eps_active
	                    FROM (

	                        SELECT pst.pst_id, pst.pst_name, eps.eps_active
	                        FROM {$config->db_name}.emppost eps
	                        LEFT JOIN {$config->db_name}.post pst ON eps.pst_id = pst.pst_id
	                        WHERE eps.emp_id = ?
	                        ORDER BY eps.eps_date DESC
	                    ) AS res
	                    WHERE res.eps_active = 0
	                    GROUP BY res.pst_name";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $empid);
	        $ps->execute();
	        $ps->bind_result($pst_id, $pst_name, $eps_active);

	        while($ps->fetch()){
	            array_push($array, $pst_name."*".$pst_id);
	        }

	        return $array;

	        $ps->close();
	        $conn->close();


	    }


	    function deleteEmp($empid){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "update {$config->db_name}.employee set emp_active = 0 where emp_id = ?";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $empid);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }else{

	            return "OK";
	        }

	        $ps->close();
	        $conn->close();


	    }

	    function deleteClinic($emp, $clinic){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "delete from {$config->db_name}.empclinic where emp_id = ? and cli_id = ?";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("ii", $emp, $clinic);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }else{

	            return "OK";
	        }

	        $ps->close();
	        $conn->close();


	    }

	    function empClinicHist($emp, $clinic){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "insert into {$config->db_name}.empclinichist(cli_id, emp_id, spc_id, eclh_date)
	                  (select cli_id, emp_id, spc_id, CURDATE() from {$config->db_name}.empclinic where emp_id = ? and cli_id = ?)";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("ii", $emp, $clinic);
	        $execute = $ps->execute();

	        if($execute == FALSE){

	            return "ERROR";

	        }else{

	            return "OK";
	        }

	        $ps->close();
	        $conn->close();
	    }

	    function editEmployee(employee $employee){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "update {$config->db_name}.employee set emp_name = ?, emp_lastname = ?, emp_surename = ?, emp_complete = ?, emp_tel = ?, emp_cel = ?
	                  where emp_id = ?";

	        $emp_name = $employee->getEmpName();
	        $emp_lastname = $employee->getEmpLastName();
	        $emp_surename = $employee->getEmpSureName();
	        $emp_complete = $employee->getEmpComplete();
	        $emp_tel = $employee->getEmpTel();
	        $emp_cel = $employee->getEmpCel();
	        $emp_id = $employee->getEmpId();

	        $ps = $conn->prepare($query);
	        $ps->bind_param("ssssssi", $emp_name, $emp_lastname, $emp_surename, $emp_complete, $emp_tel, $emp_cel, $emp_id);
	        $execute = $ps->execute();

	        if($execute == FALSE){
	            return $ps->error;
	        }
	        else{
	            return "OK";
	        }

	        $ps->close();
	        $conn->close();
	    }

	    function getSpeciality(){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);
	        $pstArray = array();

	        $query = "select pst_id from {$config->db_name}.post
	                  where spc_id <> 1";

	        $ps = $conn->prepare($query);
	        $ps->execute();
	        $ps->bind_result($pst_id);

	        while($ps->fetch()){
	            array_push($pstArray,$pst_id);
	        }

	        return $pstArray;

	        $ps->close();
	        $conn->close();
	    }

	    function getSpcId($pst){

	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "select spc_id from {$config->db_name}.post
	                  where spc_id <> 1
	                  and pst_id = ?";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $pst);
	        $ps->execute();
	        $ps->bind_result($pst_id);
	        $ps->fetch();

	        return $pst_id;

	        $ps->close();
	        $conn->close();
	    }

	    function reactivateEmp($empid) {
	        $config = new config();
	        $conn = new mysqli($config->db_server, $config->db_user, $config->db_passwd, $config->db_name);

	        $query = "update {$config->db_name}.employee set emp_active = 1 where emp_id = ?";

	        $ps = $conn->prepare($query);
	        $ps->bind_param("i", $empid);
	        $execute = $ps->execute();

	        if($execute == FALSE){
	            return "ERROR";
	        }else{
	            return "OK";
	        }

	        $ps->close();
	        $conn->close();
	    }
	}
?>