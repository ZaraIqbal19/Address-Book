@extends('admin.adminlayout')
@section('admincontent')

<div class="container">
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-bordered"
        >
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Price</th>
                    <th scope="col">Quanity</th>
                    <th scope="col">Status</th>
                    <th>Operations</th>

                </tr>
            </thead>
            <tbody>
               @foreach($prod as $p)
                 <tr class="">
                    <td scope="row">{{$p->id}}</td>
                    <td>{{$p->ProductName}}</td>
                    <td> @if(date('Y-m-d') >= $p->Sale_Start && date('Y-m-d') <= $p->Sale_End)
                        <b>{{$p->Sale_Price}}</b>
                        @else
                        <b>{{$p->RegularPrice}}</b>
                        @endif</td>
                    <td>
                        @if(date('Y-m-d') >= $p->SaleStart && date('Y-m-d') <= $p->SaleEnd)
                        <b>In Sale</b>
                        @else
                        <b>Out Of Sale</b>
                        @endif
                    </td>
                    <td>
                        <input type="number" id="quantity" placeholder="Enter Quantity">
                    </td>
                    <td>
                        <button id="mybtn" data-id="{{$p->id}}" data-name="{{$p->ProductName}}" class="btn btn-primary" onclick="addtocart()">Add To Cart</button>
                    </td>
                </tr>
               @endforeach

            </tbody>
        </table>
    </div>

</div>
<script>
    function addtocart()
    {
        var productid = $('#mybtn').data('id')
        var quantity = $('#quantity').val()
        $.ajax({
            url:"/addtocart",
            type:"post",
            data:{
                "ProductId":productid,
                "ProductQuantity":quantity,
                "_token":"{{ csrf_token() }}"
            },
            success:function(){
            Toastify({text: "Added to Cart !",
                duration: 3000,
  close: true,
  gravity: "bottom", // `top` or `bottom`
  position: "right", // `left`, `center` or `right`
  stopOnFocus: true, // Prevents dismissing of toast on hover
  style: {
    background: "linear-gradient(to right, #00b09b, #96c93d)",
  },
  onClick: function(){} // Callback after click
}).showToast();
            }
        })

    }
</script>

@endsection

