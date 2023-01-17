@extends('layouts.panel')
@section('content')
<h3>Waste Collection</h3>
<ul>
    
    <li><a href="{{url('HCFCollection/create')}}">HCFCollection </a></li>
</ul>
<h3>Billing/Payment</h3>
<ul>
    
    <li><a href="{{url('ManualTask/create')}}">ManualTask </a></li>
    <li><a href="{{url('BillingOccupancy/create')}}">BillingOccupancy </a></li>
    <li><a href="{{url('ChequeReceipt/create')}}">ChequeReceipt </a></li>
    <li><a href="{{url('BillDetail/create')}}">Custom Billing </a></li>
</ul>
<h3>Accounting</h3>
<ul>
    <li><a href="{{url('GroupHead/create')}}">Group Head </a></li>
    <li><a href="{{url('AccountingHead/create')}}">Accounting head </a></li>
    <li><a href="{{url('AccountingVoucher/create')}}">Accounting Voucher </a></li>
    <li><a href="{{url('TransferVoucher/create')}}">TransferVoucher </a></li>
    <li><a href="{{url('PartyLedger/create')}}">Party Ledger </a></li>
    <li><a href="{{url('TrailReport/create')}}">Trail Report </a></li>
    <li><a href="{{url('ProfitLoss/create')}}">ProfitLoss </a></li>
    <li><a href="{{url('Inventory/create')}}">Inventory </a></li>
    <li><a href="{{url('ExcelUpload/create')}}">ExcelUpload </a></li>
    <li><a href="{{url('Outstanding/create')}}">Outstanding </a></li>
</ul>
<h3>Organization</h3>
<ul>
    <li><a href="{{url('DieselConsumption/create')}}">DieselConsumption </a></li>
</ul>
<h3>User</h3>
<ul>
    <li><a href="{{url('Employee/create')}}">Employee </a></li>
</ul>
<h3>Client</h3>
<ul>
    <li><a href="{{url('Client/create')}}">Client </a></li>
    <li><a href="{{url('ClientGroup/create')}}">ClientGroup </a></li>
    <li><a href="{{url('ClientType/create')}}">Client type </a></li>
    <li><a href="{{url('BulkClientUpdate/create')}}">BulkClientUpdate </a></li>
    <li><a href="{{url('DebtorList/create')}}">DebtorList </a></li>
</ul>
<h3>Pharma Clients</h3>
<ul>
    <li><a href="{{url('PharmaClient/create')}}">Pharma Client </a></li>
    <li><a href="{{url('PharmaWaste/create')}}">Pharma Waste </a></li>
    <li><a href="{{url('PharmaDebtor/create')}}">Pharma Debtor </a></li>
</ul>
<h3>Support</h3>
<ul>
    <li><a href="{{url('Ticket/create')}}">Ticket </a></li>
</ul>
<h3>Raise Support</h3>
<ul>
    <li><a href="{{url('RaiseSupport/create')}}">RaiseSupport </a></li>
</ul>
<h3>Masters</h3>
<ul>
    <li><a href="{{url('Consumable/create')}}">Consumable </a></li>
    <li><a href="{{url('Department/create')}}">Department </a></li>
    <li><a href="{{url('Designation/create')}}">Designation </a></li>
    <li><a href="{{url('Bank/create')}}">Bank </a></li>
    <li><a href="{{url('Plant/create')}}">Plant </a></li>
    <li><a href="{{url('Route/create')}}">Routes </a></li>
    <li><a href="{{url('Vehicle/create')}}">Vehicle </a></li>
    <li><a href="{{url('VendorDetails/create')}}">Vendor Details </a></li>
    <li><a href="{{url('WasteContainer/create')}}">Waste Container </a></li>
</ul>
<h3>User ID</h3>
<ul>
    <li><a href="{{url('UserAccSetting/create')}}">UserAcc Setting </a></li>
    <li><a href="{{url('PersonalInfo/create')}}">Personal Details </a></li>
    <li><a href="{{url('BillingConfiguration/create')}}">BillingConfiguration </a></li>
</ul>



@endsection