<style type="text/css">
.trtitle{
  margin:-10px;
  padding:0px;
  font-size: 30px;
}
</style>
<div>
	<div style="width: 100%;float: left;border: 1px solid black;margin-top: -40px;">
		<h2 style="text-align: center;">Challan<br>{{!empty($siteaddresses[$data->site]) ? $siteaddresses[$data->site] : ''}}</h2>
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
				<span style="text-align: left;">Tare Weight : {{!empty($data->entry_weight) ? $data->entry_weight : 0}} KG</span>
				<br><span>Gross Weight : {{!empty($data->gross_weight) ? $data->gross_weight :0}} KG</span><br><span>Net Weight : {{!empty($data->net_weight) ? $data->net_weight : 0}} KG</span><br>

			</p>
			<br>
			<p>
				<span style="text-align: left;">
					Unloading Place : {{!empty( $sites[$data->site]) ? $sites[$data->site] : ''}}
				</span>
			</p>
			<br>

		</div>
		<div style="width: 50%; float: left;text-align: right;">
			<span>Date : {{!empty($data->datetime) ? date('Y-m-d' , strtotime($data->datetime)) : ''}}</span><br>
			<p></p>
			<p></p>
			<p></p>
			<p></p>
			<p></p>
			<br>
				<span style="margin-top: 10px;">
					Kanta Slip No. : {{!empty($data->kanta_slip_no) ? $data->kanta_slip_no : ''}}
				</span>
		</div>
	</div>
	<div style="clear: left;">
		@php
			$itemsarr = json_decode($data->items_included);
		@endphp
		<div style="width: 23%;float: left;">
			@foreach($itemsarr as $key => $value)
			<div style="height: 20px;width: 100px;border: 1px solid black;"></div>
			@endforeach
		</div>
		<div style="width: 50%;float: left; text-align: left;">
			@foreach($itemsarr as $key =>$value)
			<div style="margin-top: 2px;">{{!empty($items[$value]) ? $items[$value] : ''}}</div>
			@endforeach
		</div>
		</div>

	<div style="margin-top: 40px;clear: left;">
		<div style="width: 50%;float: left;">
			<p>
				Loading Plant : {{ !empty($data->plantname) ? $data->plantname : ''}}
			</p>
		</div>
		<div style="width: 50%;float: left;text-align: right;">
			<p>
				Supervisor Plant : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
		</div>		
	</div>
</div>
