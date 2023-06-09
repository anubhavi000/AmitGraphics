<style type="text/css">
.trtitle{
  margin:-10px;
  padding:0px;
  font-size: 30px;
}
*{
	font: sans-serif;
}
.circle{
	border: 1px solid black;
	height: 15px;
	width: 15px;
	margin-top: 2px;
	border-radius: 50%;
}
</style>
<div style="margin-top: -40px;">
	<div style="width: 100%;float: left;border: 1px solid black;">
		<h2 style="text-align: center;">Loading Slip<br>{{!empty($siteaddresses[$data->owner_site]) ? $siteaddresses[$data->owner_site] : ''}}</h2>
	</div>
	<div style="clear: left;width: 100%;">
		<div style="width: 50%;float: left;">
			<span style="text-align: left;">Slip No. : {{!empty($data->slip_no) ? $data->slip_no : ''}}</span><br>
			<p>
				<span style="text-align: left;">
					Vehicle No. : {{!empty($vehicles[$data->vehicle]) ? $vehicles[$data->vehicle] : ''}}
				</span>
			</p>
			<p>
				<span style="text-align: left;">
					Driver : {{!empty($data->driver) ? $data->driver : ''}}
				</span>
			</p>
			<p>
				<span style="text-align: left;">Tare Weight : {{!empty($data->entry_weight) ? $data->entry_weight : ''}} KG</span>
			</p>
			<p>
				<span style="text-align: left;">
					loading Plant : {{ !empty($plants[$data->plant]) ? $plants[$data->plant] : ''}}
				</span>
			</p>
			<br>

		</div>
		<div style="width: 50%; float: left;text-align: right;">
			<span>Date : {{!empty($data->datetime) ? date('d-m-Y' , strtotime($data->datetime)) : ''}}</span><br><br>
			<p></p>
			<p></p>
			<p></p>
			<br>
				<span style="margin-top: 9px;">
					 Weighbridge Slip No. : {{!empty($data->kanta_slip_no) ? $data->kanta_slip_no : ''}}
				</span>
		</div>
	</div>
	<div style="clear: left;">
		@php
			$items_selected = json_decode($data->items_included);
			$items_selected = !empty($items_selected) ? $items_selected : [];
		@endphp
		@foreach($items as $key => $value)
			<div style="width: 25%;float: left;">
				@if(in_array($key , $items_selected))
				<div style="float: left;background: black;" class="circle"></div><span style="margin-left: 20px;">{{$value}}</span>
				@else
				<div style="float: left;" class="circle"></div><span style="margin-left: 20px;">{{$value}}</span>
				@endif
			</div>
		@endforeach
	</div>
	{{--
	<div style="clear: left;">
		@php
			$itemsarr = json_decode($data->items_included);
		@endphp	
		<div style="width: 4%;float: left;">
			@foreach($itemsarr as $key => $value)
			<div style="height: 20px;"><div class="circle"></div></div>
			@endforeach
		</div>
		<div style="width: 50%;float: left; text-align: left;">
			@foreach($itemsarr as $key =>$value)
			<div style="margin-top: 2px;">{{!empty($items[$value]) ? $items[$value] : ''}}</div>
			@endforeach
		</div>
		</div>
		--}}
	<div style="margin-top: 40px;clear: left;">
		<div style="width: 50%;float: left;">
			<p>
				Unloading Site : {{!empty( $sites[$data->site]) ? $sites[$data->site] : ''}}
			</p>
		</div>
		<div style="width: 50%;float: left;text-align: right;">
			<p>
				Supervisor  : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
		</div>		
	</div>
</div>
