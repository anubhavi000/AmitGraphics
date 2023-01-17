<body>
    Dear Sir/Madam,
    <br>
    <br>
    <p style="text-align: justify;">
    	Please find attached the invoice for the month of {{date('M-Y',strtotime($month))}}  against Bio Medical Waste Management Services.
    	<br>
    	<br>
    	Please do not Reply on the email.<br>
    	If you have any query, Please emails on <br><a href="mailto:{{$body_part->email}}">{{$body_part->email}}</a>
    	<br>----------------------------------------------- 
    	<br>
    	<br>
    </p>
    <p style="text-align:justify;">
    	Regards,<br>
    	<b>{{$body_part->title}}</b><br>
    	 {{$body_part->address}}<br>
    	 Email : {{$body_part->email}}<br>
    	 Ph : {{$body_part->landline}}
    </p>
 
</body>