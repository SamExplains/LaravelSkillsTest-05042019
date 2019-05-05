@extends('layouts.app')
@section('content')
  {{-- jQuery --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <div class="container">
    <div class="row">

      <div class="col-8 mx-auto" id="Errors">

      </div>

      <div class="col-8 mx-auto">

        <form>

          <div class="form-group">
            <label for="productname">Product Name</label>
            <input type="text" class="form-control" id="productname" placeholder="Enter product name" required>
          </div>

          <label for="quantity_is">Quantity In Stock</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text bg-success text-white">$</span>
            </div>
            <input type="number" class="form-control" id="quantity_is" placeholder="20" required>
            <div class="input-group-append">
              <span class="input-group-text">.00</span>
            </div>
          </div>

          <label for="price_per_item">Price Per Item</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text bg-success text-white">$</span>
            </div>
            <input type="number" class="form-control" id="price_per_item" placeholder="50" required>
            <div class="input-group-append">
              <span class="input-group-text">.00</span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary" id="new_product_sumbit_btn">Submit Product</button>

        </form>

      </div>

    </div>

    <div class="row">

      <div class="col-12 mx-auto mt-5">

        <div class="card">
          <div class="card-header">
            Products Store
          </div>
          <ul class="list-group list-group-flush" id="P_Store">

          </ul>

        </div>

      </div>

    </div>

  </div>


  <script>

    $('#new_product_sumbit_btn').on('click', (event) => {
      event.preventDefault();

      /* Grab input values */
      const p_name = $('#productname').val();
      const p_quantity = $('#quantity_is').val();
      const p_price = $('#price_per_item').val();
      const _errors = $('#Errors');
      let errorsArr = [];

      console.warn(p_name);
      console.warn(p_quantity);
      console.warn(p_price);

      if (p_name.length === 0)
        errorsArr.push('invalid name');

      if (p_quantity.length === 0)
        errorsArr.push('invalid quantity');

      if (p_price.length === 0)
        errorsArr.push('invalid price');

      if (errorsArr.length === 0) {
        console.warn('Good Request');

        $.ajax({
        url: '{{ route('product.store') }}',
        type: 'POST',
        dataType: 'JSON',
        data: { _token: '{{ csrf_token() }}', productname: p_name, quantity: p_quantity, price: p_price },
          success: function (r) {
            console.warn(r);

            $.ajax({
              dataType: "json",
              url: '{{ asset('storage/products.json') }}',
              type: 'GET',
              data: { _token: '{{ csrf_token() }}' },
              success: function (r) {
                console.warn(r);

                const _store_container = $('#P_Store');
                let sum = 0;

                /* Empty */
                _store_container.empty();

                for (const element in r) {
                  console.warn(r[element]['productname']);
                  _store_container.append(`<li class="list-group-item">Product: ${ r[element]['productname'] }, Quantity: ${r[element]['quantity']}, Price Per Item: ${r[element]['price']}, <span class="alert-success p-2">Total Value: $${r[element]['total_value']}</span> </li>`);
                  sum += r[element]['total_value'];
                }

                /* Append total sum */
                _store_container.append(`<li class="list-group-item"> <span class="alert-info p-2">Total Sum $${sum}</span></li>`);
              }
            });

          }
        });

      } else {
        _errors.append(`<div id="write_error" class="alert alert-danger" role="alert">
                          You have errors! Fill in all inputs!
                        </div>`);

        setTimeout(() => {
          $('#write_error').remove();
        }, 2000);

      }

    });

    function readAndWriteFromFile() {

    }

  </script>

@endsection