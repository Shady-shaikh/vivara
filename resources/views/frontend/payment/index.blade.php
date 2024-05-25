@extends('frontend.layouts.app')
@section('title', 'My Payments')

@section('content')
 
<a href="{{url('/')}}/user/dashboard" class="btn m-3 btn-secondary">Back</a>


<h1 style="text-align: center;">My Payments</h1>
<hr>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Items</th>
                <th scope="col">Payment DateTime</th>
                <th scope="col">Amount</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($availableItems->toArray())}} --}}
            <?php
            $i=1;
            ?>
            @if(!$data->isEmpty())
            @foreach($data as $row)
            {{-- {{dd($row->get_items()->toArray())}} --}}
            @if(!empty($row->get_items()))
           <tr>

            <td>{{$i}}</td>
           
            <td>
                @foreach($row->get_items() as $item)
                <li>
                    {{$item->name}}
                </li>
                @endforeach
            </td>
            <td>{{ $row->payment_date }}</td>
            <td>{{ $row->amount }}</td>
            <td>
                <a class="btn btn-light btn-sm" href="{{route('payment.view',['id'=>$row->payment_id])}}">View</a>
            </td>
           </tr>
           <?php
           $i++;
           ?>
           @endif
           @endforeach
           @else
           <td colspan="10" class="text-center">No Payment Has Been Made Yet!</td>
         @endif

        </tbody>
    </table>
@endsection
