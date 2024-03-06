@extends('layouts.contentLayoutMaster')

@section('title', 'Pending Claims')

@section('side-menu')
@include('hospital::panels.sidebar')
@endsection

@section('vendor-style')
{{-- Page Css files --}}
{{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">--}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
@endsection

@section('page-style')
{{-- Page Css files --}}
@livewireStyles
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
@endsection

@section('content')
<div class="card invoice-preview-card">
    <div class="pb-0 card-body invoice-padding row">
        <div class="table-responsive">

            <table class="table" id="my_table">
          
                <thead>
                    <tr>
                        <th class="py-1">Medical Aid Name</th>
                        <th class="py-1">Treatment Date</th>
                        <th class="py-1">Visit ID</th>
                        <th class="py-1">Patient Name</th>
                        <th class="py-1">Medical Aid No.</th>
                        <th class="py-1">Suffix</th>
                        <th class="py-1">Claim Date</th>
                        <th class="py-1">Bill Total</th>
                        <th class="py-1">status</th>
                        <th class="py-1">file</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($claims as $item)
                    <tr class="border-bottom">

                        <td class="py-1">{{$item->medicalAid->name}}</td>
                        <td class="py-1">
                            <span class="font-weight-bold">{{$item->created_at}}</span>
                        </td>
                        <td class="py-1">
                            <span class="font-weight-bold">{{$item->visit_id}}</span>
                        </td>
                        <td class="py-1">
                            <span class="font-weight-bold">{{$item->patient->first_name}} {{$item->patient->last_name}}</span>
                        </td>
                        <td class="py-1">
                            <span class="font-weight-bold">{{$item->patient->medical_aid_number}}</span>
                        </td>
                        <td class="py-1">
                            <span class="font-weight-bold">{{$item->patient->medical_aid_suffix}}</span>
                        </td>
                        <td><span class="font-weight-bold">{{$item->created_at}}</span></td>
                        <td class="py-1">
                            <span class="font-weight-bold">${{$item->claim_amount}}</span>
                        </td>
                        <td class="py-1">
                            <span class="badge rounded-pill bg-warning">pending</span>
                        </td>
                        <td class="py-1">
                            <a href="{{route('claims-download-pdf-full-document',['visit'=>$item->visit_id])}}" target="_blank">
                                <i class='bx bxs-file-pdf' style='color:#F16060; font-size: 25px'></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <button onClick=(downloadTableToCSV())> export to excell</button>

            <script>
            
                function downloadTableToCSV(){
                  const table = document.getElementById("my_table");
                  const content = toExcel(table);

                  const link = document.createElement("a");
                  link.download = 'filename';

                  const mime_types = {
                    'json':"application/json",
                    'csv':"text/csv",
                    'excel':"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                  }

                  link.href = `data:${mime_types['excel']};charset=utf-8,${encodeURIComponent(content)}`;
                  document.body.appendChild(link);
                  //link.href = URL.createObjectURL(blob);
                  //const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8" });

                  link.click();
                  link.remove();
                }

                const toExcel = function(table){
                  //alert(table);
                  const rows = table.querySelectorAll("tr");
                  
                  /*return [...rows].map(row=>{
                    const cells = row.querySelectorAll('th , td');
                    return [...cells].map(cell => cell.textContent.trim()).join("\t\t\t")
                  }).join(",\n\n")*/

                   return [...rows].map(row=>{
                    const cells = row.querySelectorAll('th , td');
                    return [...cells].map(cell => cell.textContent.trim()).join("\t\t"+"  ")
                  }).join(",\n")

                }


                
            </script>


        </div>
        <div class="pagination">
            {{ $claims->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>
@endsection

@section('vendor-script')
{{-- Vendor js files --}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>--}}
{{-- <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>--}}
@endsection

@section('page-script')
@livewireScripts

{{-- Page js files --}}
{{-- <script src="{{ asset(mix('js/scripts/pages/reception-patient-list.js')) }}"></script>--}}
@endsection
