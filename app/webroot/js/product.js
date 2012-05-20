
function check_couponproduct(ref,val){
	var ValidChars = "0123456789.";
	   var Char;
	 var IsNumber=true;
	   for (i = 0; i < val.length && IsNumber == true; i++) 
	      { 
	      Char = val.charAt(i); 
		  if(Char=='.'){
			alert('Only Integer are allowed.');
			ref.value='1';
			return false;  
		  }
	      if (ValidChars.indexOf(Char) == -1) 
	         {
	        alert('Only Number are allowed.');
			ref.value='1';
			return false;  
	         }
			 else if(ref.value==0){
			 alert('Number are Greather than 0.');
			ref.value='1';
			return false;  
			 }
			  else if(ref.value>1){
			 alert('Only quantity 1 is allowed.');
			ref.value='1';
			return false;  
			 }
	      }
}  
function check_char(ref,val){
	var ValidChars = "0123456789.";
	   var Char;
	 var IsNumber=true;
	   for (i = 0; i < val.length && IsNumber == true; i++) 
	      { 
	      Char = val.charAt(i); 
		  if(Char=='.'){
			alert('Only Integer are allowed.');
			ref.value='';
			return false;  
		  }
	      if (ValidChars.indexOf(Char) == -1) 
	         {
	        alert('Only Number are allowed.');
			ref.value='';
			return false;  
	         }
			 else if(ref.value==0){
			 alert('Number are Greather than 0.');
			ref.value='';
			return false;  
			 }
			  
	      }
}
