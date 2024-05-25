@extends('frontend.layouts.app')
@section('title', 'Items')

@section('content')
 
<a href="{{url('/')}}/user/dashboard" class="btn m-3 btn-secondary">Back</a>


<h1 style="text-align: center;">Items</h1>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item Name</th>
                <th scope="col">Rate</th>
                <th scope="col">Usage Unit</th>
                {{-- <th scope="col">Product Type</th> --}}
                {{-- <th scope="col">Stock On Hand </th>
                <th scope="col">Available Stock</th> --}}
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($availableItems->toArray())}} --}}
            <?php
            $i=1;
            ?>
            @if(!empty($availableItems))
            @foreach($availableItems as $row)
           <tr>

            <td>{{$i}}</td>
            <td>{{ $row->name }}</td>

            <td>{{ $row->rate }}</td>
            <td>{{ $row->unit }}</td>
            {{-- <td>{{ $row->product_type }}</td>
            <td>{{ $row->stock_on_hand }}</td>
            <td>{{ $row->available_stock }}</td> --}}
            <td>
                <a class="btn" href="{{route('products.view',['id'=>$row->item_id])}}"><i class="fa-sharp fa-solid fa-eye"></i></a>
                <a class="btn btn-warning" href="{{route('products.purchase',['check'=>'d','id'=>$row->item_id])}}">Purchase</a>
                <a class="btn btn-info" href="{{route('cart.store',['id'=>$row->item_id])}}"><i class="fa-solid fa-cart-shopping"></i></a>
            </td>
           </tr>
           <?php
           $i++;
           ?>
           @endforeach
           @endif
         

        </tbody>
    </table>
@endsection
