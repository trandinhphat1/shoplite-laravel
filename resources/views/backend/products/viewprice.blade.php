@extends('backend.layouts.master')
@section ('scriptop')
<script>
    function validatePrice(input) {
        let value = parseFloat(input.value);
        if (isNaN(value) || value < 0) {
            input.value = 0;
        }
    }
</script>
@endsection
@section('content')

<div class='content'>
@include('backend.layouts.notification')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Điều chỉnh giá
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="{{route('product.priceupdate')}}">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}" />

                <div class="intro-y box p-5">
                    @foreach ($group_prices as $gprice)
                    <div class="mt-3">
                        <label for="gp{{$gprice->id}}" class="form-label">{{$gprice->title}}</label>
                        <input id="gp{{$gprice->id}}" 
                               name="gp{{$gprice->id}}" 
                               value="{{$gprice->price}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)">
                    </div>
                    @endforeach
                    
                    <div class="mt-3">
                        <label for="old_price" class="form-label">Giá trước khuyến mãi</label>
                        <input id="old_price" 
                               name="old_price" 
                               value="{{$productextend->old_price}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>
                    
                    <div class="mt-3">
                        <label for="price" class="form-label">Giá chung hiện tại</label>
                        <input id="price" 
                               name="price" 
                               value="{{$product->price}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_in" class="form-label">Giá nhập</label>
                        <input id="price_in" 
                               name="price_in" 
                               value="{{$product->price_in}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_avg" class="form-label">Giá vốn trung bình</label>
                        <input id="price_avg" 
                               name="price_avg" 
                               value="{{$product->price_avg}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        <label for="price_out" class="form-label">Giá bán</label>
                        <input id="price_out" 
                               name="price_out" 
                               value="{{$product->price_out}}" 
                               type="number" 
                               step="0.01" 
                               min="0"
                               class="form-control"
                               onchange="validatePrice(this)" 
                               required>
                    </div>

                    <div class="mt-3">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection