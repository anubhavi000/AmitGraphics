<style type="text/css">
*{
	font: sans-serif;
}
.trtitle{
  margin:-10px;
  padding:0px;
  font-size: 30px;
}
.circle{
	border: 1px solid black;
	height: 15px;
	width: 15px;
	margin-top: 2px;
	border-radius: 50%;
}
</style>
<div style="border-right: 1px solid black;border-left: 1px solid black;width: 110%;margin-left: -5%;margin-top: -5%;">
	<div style="width: 100%;float: left;border: 1px solid black;">
		<h2 style="text-align: center;">Challan<br>{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}</h2>
	</div>
	<div style="clear: left;width: 100%;">
		<div style="width: 50%;float: left;">
			<span style="text-align: left;margin-left: 6px;">Slip No. : {{!empty($data->slip_no) ? $data->slip_no : ''}}</span><br>
			<p>
				<span style="text-align: left;margin-left: 6px;">
					Vehicle No. : {{!empty($vehicles[$data->vehicle]) ? $vehicles[$data->vehicle] : ''}}
				</span><br>
				<span style="text-align: left;margin-left: 6px;">
					Driver : {{!empty($data->driver) ? $data->driver : ''}}
				</span>
			</p>
			<p>
				<span style="text-align: left;margin-left: 6px;">Tare  Weight : {{!empty($data->entry_weight) ? $data->entry_weight : 0}} KG</span>
				<br><span style="margin-left: 6px;">Gross Weight : {{!empty($data->gross_weight) ? $data->gross_weight :0}} KG</span><br><span style=";margin-top: 6px;"><b style="margin-left: 6px;">Net Weight : {{!empty($data->net_weight) ? $data->net_weight : 0}} KG</b></span><br>

			</p>
			<p>
				<span style="text-align: left;margin-left: 6px;">
					Unloading Site : {{!empty( $sites[$data->site]) ? $sites[$data->site] : ''}}
				</span>
			</p>
			<br>

		</div>
		<div style="width: 50%; float: left;text-align:right;">
			<span style="margin-right: 4px;">Date : {{!empty($data->datetime) ? date('Y-m-d' , strtotime($data->datetime)) : ''}}</span><br><br>
			<span style="margin-right: 4px;">Dispatch Date : {{!empty($data->generation_time) ? date('d-m-Y' , strtotime($data->generation_time)) : ''}}</span><br><br>
			<span style="margin-right: 4px;">Dispatch Time :  {{!empty($data->generation_minutehours) ? date('h:i:A' , strtotime($data->generation_minutehours)) : ''}}</span>
			<p></p>
			<p></p>
			<p></p>
			<br>
				<span  style="margin-top: 9px;text-align: left;">
					 Weighbridge Slip No. : {{!empty($data->kanta_slip_no) ? $data->kanta_slip_no : ''}}
				</span>
		</div>
	</div>
	<div style="clear: left;margin: 0px;text-align: center;">
		<span ><b>Material : </b></span>
		@php
			$items_selected = json_decode($data->items_included);
			$items_selected = !empty($items_selected) ? $items_selected : [];
		@endphp
		@foreach($items as $key => $value)
			@if(in_array($key , $items_selected))
				<span>{{$value}}</span>
			@endif
		@endforeach
	</div>

	<div style="margin-top: 20px;clear: left;">
		<div style="width: 50%;float: left;border-left: 1px solid black;margin-left:-1px;border-bottom: 1px solid black;">
			<p style="margin-left: 6px;margin-right: 4px;">
				Loading Plant : {{ !empty($data->plantname) ? $data->plantname : ''}}
			</p>	
			<p style="margin-left: 6px;margin-right: 4px;">
				Reciever Signature & Stamp
			</p>
			<p></p>
			<p></p>	
			<p></p>			
		</div>
		<div style="width: 50%;float: left;text-align: right;border-bottom: 1px solid black;border-right: 1px solid black;">
			<p style="margin-right: 4px;">
				Supervisor Plant : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
			<p>
				For 
				<b>
				{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}
				</b>
			</p>	
			<p></p>
			<p></p>
			<p></p>			
		</div>	
	</div>
</div>





<!-- Second copy -->
<div style="clear: left;width: 110%;margin-left: -5%;border-left:1px solid black;border-right:1px solid black;margin-top: 200px;">
	<div style="width: 100%;float: left;border: 1px solid black;">
		<h2 style="text-align: center;">Challan<br>{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}</h2>
	</div>
	<div style="clear: left;width: 100%;">
		<div style="width: 50%;float: left;">
			<span style="text-align: left;margin-left: 4px;">Slip No. : {{!empty($data->slip_no) ? $data->slip_no : ''}}</span><br>
			<p>
				<span style="text-align: left;margin-left: 4px;">
					Vehicle No. : {{!empty($vehicles[$data->vehicle]) ? $vehicles[$data->vehicle] : ''}}
				</span><br>
				<span style="text-align: left;margin-left: 4px;">
					Driver : {{!empty($data->driver) ? $data->driver : ''}}
				</span>
			</p>
			<p>
				<span style="text-align: left;margin-left: 4px;">Tare  Weight : {{!empty($data->entry_weight) ? $data->entry_weight : 0}} KG</span>
				<br><span style="margin-left: 4px;">Gross Weight : {{!empty($data->gross_weight) ? $data->gross_weight :0}} KG</span><br><span style=";margin-top: 6px;"><b style="margin-left: 4px;">Net Weight : {{!empty($data->net_weight) ? $data->net_weight : 0}} KG</b></span><br>

			</p>
			<p>
				<span style="text-align: left;margin-left: 4px;">
					Unloading Site : {{!empty( $sites[$data->site]) ? $sites[$data->site] : ''}}
				</span>
			</p>
			<br>

		</div>
		<div style="width: 50%; float: left;text-align:right;">
			<span style="margin-right: 4px;">Date : {{!empty($data->datetime) ? date('Y-m-d' , strtotime($data->datetime)) : ''}}</span><br><br>
			<span style="margin-right: 4px;">Dispatch Date : {{!empty($data->generation_time) ? date('d-m-Y' , strtotime($data->generation_time)) : ''}}</span><br><br>
			<span style="margin-right: 4px;">Dispatch Time :  {{!empty($data->generation_minutehours) ? date('h:i:A' , strtotime($data->generation_minutehours)) : ''}}</span>
			<p></p>
			<p></p>
			<p></p>
			<br>
				<span  style="margin-top: 9px;text-align: left;">
					 Weighbridge Slip No. : {{!empty($data->kanta_slip_no) ? $data->kanta_slip_no : ''}}
				</span>
		</div>
	</div>
	<div style="clear: left;margin: 0px;text-align: center;">
		<span ><b>Material : </b></span>
		@php
			$items_selected = json_decode($data->items_included);
			$items_selected = !empty($items_selected) ? $items_selected : [];
		@endphp
		@foreach($items as $key => $value)
			@if(in_array($key , $items_selected))
				<span>{{$value}}</span>
			@endif
		@endforeach
	</div>

	<div style="margin-top: 20px;clear: left;">
		<div style="width: 50%;float: left;border-left: 1px solid black;margin-left:-1px;border-bottom: 1px solid black;">
			<p style="margin-left: 4px;">
				Loading Plant : {{ !empty($data->plantname) ? $data->plantname : ''}}
			</p>	
			<p style="margin-left: 4px;">
				Reciever Signature & Stamp
			</p>	
			<p></p>			
			<p></p>
			<p></p>			
		</div>
		<div style="width: 50%;float: left;text-align: right;border-bottom: 1px solid black;border-right: 1px solid black;">
			<p>
				Supervisor Plant : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
			<p>
				For 
				<b>
				{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}
				</b>
			</p>	
			<p></p>			
			<p></p>
			<p></p>
		</div>		
	</div>
</div>
