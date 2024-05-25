@extends('frontend.layouts.app')
@section('title', 'My Cart')

@section('content')

    <a href="{{ url('/') }}/user/dashboard" class="btn m-3 btn-secondary">Back</a>


    <h1 style="text-align: center;">Cart Items</h1>
    <hr>
    <form action="{{ route('cart.update') }}" method="post">
        @csrf
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item Image</th>
                <th scope="col">Item Name</th>
                <th scope="col">Category</th>
                <th scope="col">Color</th>
                <th scope="col">Quantity </th>
                <th scope="col">Rate</th>
                <th scope="col">Usage Unit</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($availableItems->toArray())}} --}}
            <?php
            $i = 1;
            $total_amt = 0;
            $total_quant = 0;
            $items = [];
            ?>
            {{-- {{dd($availableItems->toArray())}} --}}
            @if (!$availableItems->isEmpty())
                @foreach ($availableItems as $row)
                    @if (!empty($row->get_items))
                        <?php

                        $total_amt += $row->get_items[0]['rate'] * $row->quantity;
                        
                        $items[] = $row->item_id;
                        ?>
                        <tr>

                            <td>{{ $i }}</td>
                            <td>
                                @if(!empty($row->item_image))
                                <a href="{{ asset('/public/frontend-assets/images/').'/'.$row->item_image }}" target="_blank">
                                <img src="{{ asset('/public/frontend-assets/images/').'/'.$row->item_image }}" alt="No-Image" style='width:40px;'>
                                </a>
                                @endif
                            </td>
                            <td>{{ $row->get_items[0]['name'] }} &nbsp;
                                @if (!empty($row->scheme_title))
                                    {{ ' (' . $row->scheme_title . ')' }}
                                @endif
                            </td>
                            <td>{{ $row->category??'' }}</td>
                            <td>{{ $row->variant??'' }}</td>
                            <td>
                                
                                    <input type="number" name="quantity[]" value="{{ $row->quantity }}"
                                        class="form-group " id="quantityInput"
                                        oninput="this.value = Math.max(0, this.value);" style="width: 100px;">
                                    <input type="hidden" name="item_id[]" value="{{ $row->item_id }}">
                            
                         
                            </td>
                            <td>{{ $row->get_items[0]['rate'] }}</td>
                            <td>{{ $row->get_items[0]['unit'] }}</td>
           
                            <td>
                                <a class="btn btn-light" href="{{ route('cart.view', ['id' => $row->item_id]) }}">View</a>
                                <a class="btn btn-danger" href="{{ route('cart.destroy', ['id' => $row->cart_id]) }}">Delete</a>
                                {{-- <a class="btn btn-warning" href="{{route('cart.edit',['id'=>$row->item_id])}}"><i class="fa-sharp fa-solid fa-pencil"></i></a> --}}
                            </td>
                        </tr>


                        <?php
                        $i++;
                        ?>
                    @endif
                @endforeach
                {{-- <tr>
            <td></td>
            <td>Total :</td>
            <td>
                {{$total_quant}}
            </td>
            <td></td>
            <td>{{$total_amt}}</td>
            <td></td>
           </tr> --}}
            @else
                <td colspan="10" class="text-center">Cart is empty!</td>
            @endif

        </tbody>
    </table>

    @if (!$availableItems->isEmpty())
        <?php
        $items = implode(',', $items);
        ?>
        <div class="text-center">
            Total Amount:
            <input type="text" style="width: 75px;border:none;outline:none;background-color:transparent;"
                value=" {{ $total_amt }}" readonly>
            <button type="submit" class="btn  btn-success">Update</button>
            <a href="{{ route('products.checkout', ['check' => 'c', 'data' => $items]) }}"
                class="btn btn-info">Continue</a>
        </div>
    </form>
    @endif
    <br>
@endsection
