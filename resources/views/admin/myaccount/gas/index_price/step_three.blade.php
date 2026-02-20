<table class="table table-bordered" id="offer_table">
    <thead>
        <tr>
            <th>OFERTA</th>
            <th class="text-center">FACTURA ACTUAL</th>
            <th class="text-center">PAGARÍAS…</th>
            <th class="text-center">COMISIONES</th>
        </tr>
    </thead>
    <tbody>
        @php
            usort($result, function($a, $b) {
                return $a['totalSimulatedInvoice'] <=> $b['totalSimulatedInvoice'];
            });
        @endphp
        @foreach ($result as $key=>$item)
            <tr>
                <td>
                    <div class="checkbox">
                        <input type="radio" class="offercheck" onclick="offercheck({{$item['offer_id']}}, )" name="offer" id="offer{{$key}}" value="{{$item['offer_id']}}" {{$item['total_invoice_now'] < $item['totalSimulatedInvoice'] ? 'disabled' : '' }}>
                        <label class="{{$item['total_invoice_now'] < $item['totalSimulatedInvoice'] ? 'text-color-red' : '' }}" for="offer{{$key}}">{{$item['company_name']}} {{$item['name_offer']}} </label>
                    </div>
                </td>
                <td class="text-center {{$item['total_invoice_now'] < $item['totalSimulatedInvoice'] ? 'text-color-red' : '' }}">{{number_format($item['total_invoice_now'], 2, ',', '.')}} €</td>
                <td class="text-center {{$item['total_invoice_now'] < $item['totalSimulatedInvoice'] ? 'text-color-red' : '' }}">{{number_format($item['totalSimulatedInvoice'], 2, ',', '.')}} €</td>
                <td class="text-center {{$item['total_invoice_now'] < $item['totalSimulatedInvoice'] ? 'text-color-red' : '' }}">{{number_format(round($item['final_commission']), 2, ',', '.')}} € </td>
            </tr>
        @endforeach


    </tbody>
</table>

<input type="hidden" name="price_id" id="price_id" value="">

<script type="module">
window.offercheck = function(val) {

    $("#price_id").val(val);
}

$(function () {
    // $('#offer_table').DataTable();
    // $('#offer_table').DataTable({
    //     "pageLength": 50
    // });
    // $('#offer_table').DataTable({
    //     "pageLength": 50,
    //     "language": {
    //         "decimal":        "",
    //         "emptyTable":     "No data available in table",
    //         "info":           "MOSTRAR _START_ A _END_ DE _TOTAL_ RESULTADOS",
    //         "infoEmpty": "Mostrando RESULTADOS del 0 al 0 de un total de 0 RESULTADOS",
    //         "infoFiltered":   "(filtered from _MAX_ total entries)",
    //         "infoPostFix":    "",
    //         "thousands":      ",",
    //         "lengthMenu": "MOSTRAR _MENU_ RESULTADOS",
    //         "loadingRecords": "Loading...",
    //         "processing":     "",
    //         "search":         "Buscar:",
    //         "zeroRecords": "No se encontraron resultados",
    //         "paginate": {
    //             "first":      "First",
    //             "last":       "Last",
    //             "next":       "SIGUIENTE",
    //             "previous":   "ANTERIOR"
    //         },
    //         "aria": {
    //             "orderable":  "Order by this column",
    //             "orderableReverse": "Reverse order this column"
    //         }
    //     }

    // });



    $('#offer_table').DataTable({
        "pageLength": 50,
        "language": {
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "MOSTRAR _START_ A _END_ DE _TOTAL_ RESULTADOS",
            "infoEmpty": "Mostrando RESULTADOS del 0 al 0 de un total de 0 RESULTADOS",
            "infoFiltered":   "(filtered from _MAX_ total entries)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu": "MOSTRAR _MENU_ RESULTADOS",
            "loadingRecords": "Loading...",
            "processing":     "",
            "search":         "Buscar:",
            "zeroRecords": "No se encontraron resultados",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "SIGUIENTE",
                "previous":   "ANTERIOR"
            },
            "aria": {
                "orderable":  "Order by this column",
                "orderableReverse": "Reverse order this column"
            }
        },
        "columnDefs": [
            {
                "targets": [1, 2, 3], // Assuming these are the columns with currency values
                "render": function(data, type, row) {
                    if (type === 'sort' || type === 'type') {
                        return parseFloat(data.replace(/[^0-9,-]+/g, "").replace(",", "."));
                    }
                    return data;
                }
            }
        ]
    });
});
</script>
