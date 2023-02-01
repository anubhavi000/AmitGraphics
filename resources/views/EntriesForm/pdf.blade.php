<style type="text/css">
.trtitle{
  margin:-10px;
  padding:0px;
  font-size: 30px;
}
</style>
<div>
	<div style="width: 24%;float: left;">
		<!-- <img src="{{asset('images/logo-light.png')}}"> -->
	</div>
	<div style="width: 50%;float: left;">
		<h2 style="text-align: center;">{{ !empty($sites[$data->site]) ? $sites[$data->site] : ''}}<br>{{!empty($siteaddresses[$data->site]) ? $siteaddresses[$data->site] : ''}}</h2>
	</div>
	<div style="clear: left;width: 100%;">
		<div style="width: 50%;float: left;">
			<span style="text-align: left;">Slip No. : {{!empty($data->slip_no) ? $data->slip_no : ''}}</span><br>
			<p>
				<span style="text-align: left;">
					Vehicle No. : {{!empty($vehicles[$data->vehicle]) ? $vehicles[$data->vehicles] : ''}}
				</span>
			</p>
			<br>
			<p>
				<span style="text-align: left;">Tare Weight : {{!empty($data->tare_weight) ? $data->tare_weight : ''}}</span>
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
		<table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
			<thead>
				<th>Item</th>
				<th>Item Name</th>
			</thead>
			<tbody>
				@foreach($itemsarr as $key =>$value)
					<tr>
						<td style="text-align: center;">{{ $key +1 }}</td>
						<td style="text-align: center;">{{ !empty($items[$value]) ? $items[$value] : ''}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div style="margin-top: 40px;clear: left;">
		<div style="width: 50%;float: left;">
			<p>
				Loading Plant : {{ !empty($plants[$data->plant]) ? $plants[$data->plant] : ''}}
			</p>
		</div>
		<div style="width: 50%;float: left;text-align: right;">
			<p>
				Supervisor Plant : {{ !empty($supervisors[$data->supervisor]) ? $supervisors[$data->supervisor] : ''}}
			</p>
		</div>		
	</div>
</div>
