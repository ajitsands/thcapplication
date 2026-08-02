<?PHP

    $DBConn1 = new DBConnection();
    $varDBConnection1 = $DBConn1->ConnectToMYSQL();
   // mysqli_query("SET CHARACTER SET utf8",$varDBConnection1);
   // mysqli_query("SET NAMES 'utf8'",$varDBConnection1);
        $varDBConnection1->query("SET character_set_client=utf8");
        $varDBConnection1->query("SET character_set_connection=utf8");
        $varDBConnection1->query("SET character_set_results=utf8");
        $agreement_id=$_GET["agreement_id"];
    $result = mysqli_query($varDBConnection1,"Select * from  tbl_agreements where ids='".$_GET["agreement_id"]."' ");
    //echo "Select * from  tbl_agreements where ids='".$_GET["agreement_id"]."' and apply_seal='true'";
    while($row=mysqli_fetch_assoc($result)) {
        $out_put= $row['agreement_template'];
        $first_party_sign=$row['first_party_signature'];
        $first_party_sign_date=$row['first_party_sign_date'];
        $second_party_sign= $row['second_party_signature'];
        $second_party_sign_date=$row['second_party_sign_date'];
        
        $witness1_name = $row['witness1_name'];
        $witness1_personal_no  = $row['witness1_personal_no'];
        $witness1_sign = $row['witness1_signature'];
        
        $witness2_name = $row['witness2_name'];
        $witness2_personal_no  = $row['witness2_personal_no'];
        $witness2_sign = $row['witness2_signature'];
        
        $varifier_sign = $row['verifier_signature'];
        $varifier_sign_date = $row['verifier_sign_date'];
        
        $secondparty_id = $row['second_party_ids'];
        
        $apply_seal=$row['apply_seal'];
        $contract_date=$row['contract_date'];
        $contract_date = date("d-m-Y", strtotime($contract_date));
        
        $advanceFee = $row['advance_fee'];
        //$agreement_template = $row['agreement_template'];
    }
    
    $result_parties = mysqli_query($varDBConnection1,"Select names,personal_no,email_id from  tbl_second_party where ids=".$secondparty_id);
    
    while($row=mysqli_fetch_assoc($result_parties)) {
        $second_party_name= $row['names'];
        $second_party_number=$row['personal_no'];
        $second_party_email=$row['email_id'];
       
        
    }
    
     $result_parties1 = mysqli_query($varDBConnection1,"Select * from  tbl_first_party ");
    
    while($row1=mysqli_fetch_assoc($result_parties1)) {
        $first_party_name= $row1['names'];
       
       
        
    }
?>