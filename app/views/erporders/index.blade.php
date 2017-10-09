@extends('layouts.erp')
@section('content')

<br><div class="row">
  <div class="col-lg-12">
  <h3>Sales Orders</h3>

<hr>

</div>  
</div>


<div class="row">
  <div class="col-lg-12">

    @if (Session::has('flash_message'))

      <div class="alert alert-success">
      {{ Session::get('flash_message') }}
     </div>
    @endif

    @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif
    
    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('salesorders/create')}}">New Sales Order </a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Client</th>
        <th>Order #</th>
        <th>Date</th>
        <th>status</th>
        <th></th>
        <!-- <th></th> -->

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($orders as $order)
        @if($order->type == 'sales')
        <tr>

          <td> {{ $i }}</td>
          <td>{{ $order->client->name }}</td>
          <td>{{$order->order_number }}</td>
          <td>{{$order->date }}</td>
          
          @if($order->status === "delivered")
          <td><span class="label label-success">Delivered</td>
          @elseif($order->status === "new")
          <td><span class="label label-default">New</td>
          @else
          <td><span class="label label-danger">Cancelled</td> 
          @endif
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('erporders/show/'.$order->id)}}">View</a></li>

                   @if($order->status != "cancelled")
                    <li><a href="{{URL::to('approve/cancel/'.$order->id)}}"  onclick="return (confirm('Are you sure you want to cancel this order?'))">Cancel</a></li>
                    
                    <li><a href="{{URL::to('erporders/delivered/'.$order->id)}}">Delivered</a></li>
                  @endif
                  </ul>

                  
              </div>

                    </td>


               <!--  <td>
                      <a href="#" class="btn btn-info btn-sm">Receive Payment</a>
                  </td> -->



        </tr>

        <?php $i++; ?>
        @endif
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>

@stop