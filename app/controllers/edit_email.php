<?php  
ob_start();
session_start();
include('../config.php');


$id = $_GET['id'];
$query = "select * from email_listing where id = '".$id."'";
$res = mysql_query($query);
$record = mysql_fetch_array($res);

if(isset($_POST['update']))
{
  $email = $_POST['email'];
  $location = $_POST['location'];
  $active = $_POST['status'];

  $sql_unique="select email from email_listing where email='".trim($email)."' and id !='".$id."'";
  $resultcheck=mysql_query($sql_unique);
  $num= mysql_num_rows($resultcheck);
  
	if ($num ==0) {	
  
  
  $sql= "update email_listing set 
								email = '".$email."',
								location_id = '".$location."',
								active = '".$active."' where id = '".$id."'";
  $result=mysql_query($sql);
  $_SESSION['msg']="Record has been updated successfully !";	
  header("Location:email.php");
 
 } else {
 
	$error_msg = "This email address is already exists in our database !";
 
 }
 
 


/* 

if($result)
{
  $_SESSION['msg']="Record has been updated successfully";	
  header("Location:email.php");
 //$error_msg = "Record Updated Successfully";
}
else
{
 $error_msg = "Record Not Updated";
} 

*/


}

							  
?>
<?php  include('header.php'); ?> 
<form name="addlocation" method="post" id="add" action="edit_email.php?id=<?php echo $_GET['id'];?>&lid=<?php echo $_GET['lid'];?>" onsubmit return()">
<table  align="center" width="60%" cellspacing="2" cellpadding="0" border="0" style="border: 1px solid rgb(205, 228, 241);">
											
    <tbody>
	    <tr bgcolor="#3ea3d1" >
	      <td colspan="2" ><span style="padding-left:5px"><b>Edit Email</b></span></td>
		  
	   </tr>
	   <?php if($error_msg!=''){ ?>	
              <tr>
                <td colspan="2" class="blue_txt_normal" ><p><b><?=$error_msg;?></b></p></td>
                </tr>
              
			  <?php } ?>	
	   <tr>
	      <td>Email :</td>
		  <td><input type="text" name="email" value="<?php echo $record['email']; ?>" id="location"></td>
	   </tr>
	   <tr>
	      <td>&nbsp;</td>
		  <td>&nbsp;</td>
	   </tr>
	  <tr>
	      <td>Location :</td>
		  <td><select name="location"  id=location style="width:150px">
				<?php 
			//	echo $id;
			 
			 $query = "select * from location where active='1' ORDER BY name ASC ";
			$res = mysql_query($query);

			 
		     while($row = mysql_fetch_array($res))
			 {
			 
			 
			 ?>
				
				<option <?php if($_GET['lid']==$row['id']) echo "selected";?> value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
		<?php 
		}
		 ?>
			  </select>
		  </td>
	   </tr>
	   <tr>
	      <td>Status :</td>
		  <td><select name="status" id="status" style="width:150px">
		  
		    <option <?php  if($record['active']==1) echo "selected";?> value="1">Active</option>
			
			<option <?php  if($record['active']==0) echo "selected";?> value="0">Deactive</option>
			</select>
		  </td>
	   </tr>
	   <tr>
	      <td></td>
		  <td></td>
	   </tr>
	   <tr>
	      <td></td>
		  <td><input type="submit" name="update" value="Update">
		  <a href="email.php"><input type="button" name="cancel" value="Cancel"></a>
		  </td>
	   </tr>
             
             
            
    </tbody>
</table>
</form>

<?php  include('footer.php'); ?> 