<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <div id="app">
      <div class="main-wrapper">
        <div class="main-content">
          <div class="container">
            <form method="post" action="{{ route('products.update', $product->id) }}">
            @method('PUT')
              @csrf
              <div class="card mt-5">
                <div class="card-header">
                  <h3>Edit Product</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                      <div class="alert alert-danger">
                        <div class="alert-title"><h4>Whoops!</h4></div>
                          There are some problems with your input.
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                      </div> 
                    @endif

                    @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="mb-3">
                      <label class="form-label">SKU</label>
                      <input type="text" class="form-control" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="#SKU">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}"  placeholder="Name">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Price</label>
                      <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}"  placeholder="Price">
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Brand</label>
                      <select name="brand_id" class="form-control">
                        <option value="">-- Brand --</option>
                        @foreach ($brands as $brandID => $name)
                          <option value="{{ $brandID }}" @selected(old('brand_id') == $brandID || $product->brand_id == $brandID)>
                            {{ $name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Category</label>
                      @php
                        $selectedCategoryIDs = $product->categories->pluck('id')->toArray();
                      @endphp
                      @foreach ($categories as $categoryID => $categoryName)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $categoryID }}" @checked(in_array($categoryID, $selectedCategoryIDs))>
                          <label class="form-check-label">
                            {{ $categoryName }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Stock</label>
                      <input type="text" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}"  placeholder="Stock">
                    </div>
                </div>
                <div class="card-footer">
                  <button class="btn btn-primary" type="submit">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>