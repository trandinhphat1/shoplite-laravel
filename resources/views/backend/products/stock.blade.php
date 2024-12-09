@extends('backend.layouts.master')
@section('content')

<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Nhập xuất kho sản phẩm: {{$product->title}}
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="{{route('product.stock.update',$product->id)}}">
                @csrf
                <div class="intro-y box p-5">
                    <div>
                        <label for="crud-form-1" class="form-label">Số lượng hiện tại</label>
                        <input id="crud-form-1" type="text" class="form-control w-full" value="{{$product->stock}}" readonly>
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-2" class="form-label">Loại thao tác</label>
                        <select id="crud-form-2" name="type" class="form-select w-full">
                            <option value="in">Nhập kho</option>
                            <option value="out">Xuất kho</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-3" class="form-label">Số lượng</label>
                        <div class="input-group">
                            <input id="crud-form-3" type="number" name="quantity" class="form-control" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="crud-form-4" class="form-label">Ghi chú</label>
                        <textarea id="crud-form-4" name="note" class="form-control" placeholder="Nhập ghi chú"></textarea>
                    </div>
                    <div class="text-right mt-5">
                        <button type="button" class="btn btn-outline-secondary w-24 mr-1">Hủy</button>
                        <button type="submit" class="btn btn-primary w-24">Lưu</button>
                    </div>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Stock History -->
            <div class="intro-y box p-5">
                <div class="flex items-center">
                    <h2 class="font-medium text-base mr-auto">
                        Lịch sử nhập xuất kho
                    </h2>
                </div>
                <div class="mt-5">
                    @foreach($history as $item)
                    <div class="intro-x">
                        <div class="flex">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                <i data-lucide="{{$item->type == 'in' ? 'arrow-down' : 'arrow-up'}}" class="w-6 h-6 text-{{$item->type == 'in' ? 'success' : 'danger'}}"></i>
                            </div>
                            <div class="ml-5">
                                <div class="font-medium">{{$item->type == 'in' ? 'Nhập kho' : 'Xuất kho'}} - {{$item->quantity}} sản phẩm</div>
                                <div class="text-slate-500 text-xs mt-0.5">{{$item->created_at->format('d/m/Y H:i:s')}}</div>
                                @if($item->note)
                                <div class="text-slate-500 mt-1">{{$item->note}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- END: Stock History -->
        </div>
    </div>
</div>

@endsection
