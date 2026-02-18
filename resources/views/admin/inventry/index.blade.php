@extends('layouts.app')
@section('content')

    <section class="user-dashboard-sec">
        <div class="container-fluid container-gap">
            <div class="row">
                @include('admin.includes.leftmenu')
                <div class="userwrap-rgt">
                    <div class="user-dashboard-dtls">
                        <div class="user-heading">Inventry Details</div>
                        <div class="user-body">

                            <div class="row justify-content-center">
                                <div class="col-xl-12 col-md-12 col-12">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-bordered table-hover companyTable">
                                        <thead class="thead-dark">
                                            <tr>
                                                <td scope="col">
                                                    <input id="select_all" type="checkbox">
                                                </td>
                                                <th scope="col">type</th>
                                                <th scope="col">model</th>
                                                <th scope="col">finish</th>
                                                <th scope="col">design</th>
                                                <th scope="col">shade</th>
                                                <th scope="col">width</th>
                                                <th scope="col">height</th>
                                                <th scope="col">tspl</th>
                                                <th scope="col">all_stock</th>
                                                <th scope="col">ultimate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')


<script type="module">
    var table; // ✅ Declare globally

    $(document).ready(function () {

        table = $('.companyTable').DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 350,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('admin.inventry_details') }}",
                data: function (d) {
                    d.company_name = $('#filter_company').val();
                    d.offer = $('#filter_offer').val();
                    d.accessfee_title = $('#filter_accessfee').val();
                }
            },
            columns: [
                { data: 'multipleCheckbox', orderable: false, searchable: false },
                { data: 'type' },
                { data: 'model' },
                { data: 'finish' },
                { data: 'design' },
                { data: 'shade' },
                { data: 'width' },
                { data: 'height' },
                { data: 'tspl' },
                { data: 'all_stock' },
                { data: 'ultimate' },
            ]
        });

        // ✅ FILTER EVENTS
        $('#filter_company, #filter_offer, #filter_accessfee').on('keyup change', function () {
            table.draw();
        });

        // ✅ RESET FILTERS
        $('#reset_filters').on('click', function () {
            $('#filter_company').val('');
            $('#filter_offer').val('');
            $('#filter_accessfee').val('');
            table.draw();
        });

    });
</script>



<script type="module">
    

    $(document).on('click', '#select_all', function() {
		$(".emp_checkbox").prop("checked", this.checked);
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");

        if($("input.emp_checkbox:checked").length!=0){
            $(".delete_section").show();
        }else{
            $(".delete_section").hide();
        }
	});
	$(document).on('click', '.emp_checkbox', function() {
		if ($('.emp_checkbox:checked').length == $('.emp_checkbox').length) {
			$('#select_all').prop('checked', true);
		} else {
			$('#select_all').prop('checked', false);
		}
		$("#select_count").html($("input.emp_checkbox:checked").length+" Selected");
        if($("input.emp_checkbox:checked").length!=0){
            $(".delete_section").show();
        }else{
            $(".delete_section").hide();
        }
	});

    $('#delete_records').on('click', function(e) {
        var employee = [];
        $(".emp_checkbox:checked").each(function() {
            employee.push($(this).data('emp-id'));
        });
        if(employee.length <=0)  {
            alert("Please select records.");
        }
        else {
            var WRN_PROFILE_DELETE = "Are you sure you want to delete "+(employee.length>1?"these":"this")+" row?";
            var checked = confirm(WRN_PROFILE_DELETE);
            if(checked == true) {
                var selected_values = employee.join(",");
                $.ajax({
                    type: "POST",
                    url: base_url+"/admin/multidelete/fixedprice",
                    cache:false,
                    data: 'deleted_id='+selected_values,
                    success: function(data) {
                        var obj=JSON.parse(data);
                        if(obj.status==1){
                            Swal.fire({
                                title: 'Success',
                                text: obj.msg,
                                icon: 'success',
                            });
                            window.location.href = base_url+"/admin/company-price";
                        }else if(obj.status==0){
                            Swal.fire({
                                title: 'Error',
                                text: obj.msg,
                                icon: 'warning',
                            });
                        }
                    }
                });
            }
        }
    });

    // $('#filter_company, #filter_offer, #filter_accessfee').on('keyup change', function () {
    //     table.draw();
    // });

    // $('#reset_filters').on('click', function () {
    //     $('#filter_company').val('');
    //     $('#filter_offer').val('');
    //     $('#filter_accessfee').val('');
    //     table.draw();
    // });


</script>
<style>

  </style>
@endpush
