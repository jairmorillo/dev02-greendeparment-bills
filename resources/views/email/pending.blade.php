<html>
<head>

<title>Green Department</title>
</head>
<body>
<center>
 <table borde="0" style="border-collapse: collapse ; width:600px; font-family:Arial;" >
     
	<tr style="background:#009544;border:none; height:150px">
		<td style="width:23.33%;" ></td>
		<td style="width:53.33%;">
	
		<img src="https://bill.greendepartment.org/image/green_department_logo.png" style="width:100%;" />
		<br></td>
		<td style="width:23.33%;" ></td>
	</tr> 
	<tr>
	<td colspan="3" style="text-align:center;font-size:1.2em;"><br>
		<h1>Hello,<b>  {{ $data->customer_name }}</b></h1>This is the billing department of the <b>Green Department INC</b>, we remind you that you have an invoice to pay.<br> If you want to see the invoice, click on the button.
	</td>
	</tr>
	<tr style="text-align:center;">
		<td colspan="3" style="text-align:center; "><br>		
				<center>	<a href="https://bill.greendepartment.org/pdf/invoice/{{$data->id}}" style="
						background: #009544;
						color: #fff;
						width: 150px;
						display: block;
						padding: 10px 5px;
						border-radius: 25px;
						text-decoration: none;
						font-size:1.5em;
					">Download</a> </center>
		<br><br>
		</td>
	
	</tr>	
	<tr style="background:#009544;border:none; height:100px">
		<td colspan="3" style="width:100%; text-align:center; color:#fff;"><br> <b>Questions?</b> Contact Green Department INC at <br> 	<b>info@greendepartment.org</b>  or <br> call at <br> <b>+1(800) 824-4440</b>.
			<br>
			<br>
	    </td>
	</tr> 
 </table>
</center>
</body>
</html>