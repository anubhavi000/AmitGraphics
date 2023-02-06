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
<div>
	<div style="width: 100%;float: left;border: 1px solid black;margin-top: -40px;">
		<h2 style="text-align: center;">Challan<br>{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}</h2>
	</div>
	<div style="clear: left;width: 100%;">
		<div style="width: 50%;float: left;">
			<span style="text-align: left;">Slip No. : {{!empty($data->slip_no) ? $data->slip_no : ''}}</span><br>
			<p>
				<span style="text-align: left;">
					Vehicle No. : {{!empty($vehicles[$data->vehicle]) ? $vehicles[$data->vehicle] : ''}}
				</span><br>
				<span style="text-align: left;">
					Driver : {{!empty($data->driver) ? $data->driver : ''}}
				</span>
			</p>
			<p>
				<span style="text-align: left;">Tare  Weight : {{!empty($data->entry_weight) ? $data->entry_weight : 0}} KG</span>
				<br><span>Gross Weight : {{!empty($data->gross_weight) ? $data->gross_weight :0}} KG</span><br><span style=";margin-top: 6px;"><b>Net Weight : {{!empty($data->net_weight) ? $data->net_weight : 0}} KG</b></span><br>

			</p>
			<p>
				<span style="text-align: left;">
					Unloading Site : {{!empty( $sites[$data->site]) ? $sites[$data->site] : ''}}
				</span>
			</p>
			<br>

		</div>
		<div style="width: 50%; float: left;text-align:left;">
			<span style="margin-left: 60%;">Date : {{!empty($data->datetime) ? date('Y-m-d' , strtotime($data->datetime)) : ''}}</span><br><br>
			<span style="margin-left: 42%;">Dispatch Date : {{!empty($data->generation_time) ? date('d-m-Y' , strtotime($data->generation_time)) : ''}}</span><br><br>
			<span style="margin-left: 42%;">Dispatch Time :  {{!empty($data->generation_time) ? date('h:i:A' , strtotime($data->generation_time)) : ''}}</span>
			<p></p>
			<p></p>
			<p></p>
			<br>
				<span style="margin-left: 42%;" style="margin-top: 9px;">
					Kanta Slip No. : {{!empty($data->kanta_slip_no) ? $data->kanta_slip_no : ''}}
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
		<div style="width: 50%;float: left;">
			<p>
				Loading Plant : {{ !empty($data->plantname) ? $data->plantname : ''}}
			</p>	
			<p>
				Reciever Signature & Stamp
			</p>	
		</div>
		<div style="width: 50%;float: left;text-align: right;">
			<p>
				Supervisor Plant : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
			<p>
				For 
				<b>
				{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}
				</b>
			</p>				
		</div>		
	</div>
</div>
