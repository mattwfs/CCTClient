@extends('layouts.admin')
@section('main-content')
<table class="table table-bordered table-striped">
 <thead>
   <tr>
     <th>Date</th>
     <th>Email</th>
     <th>Status</th>
     <th></th>
   </tr>
 </thead>
  <tbody>
    @if(count($referrals))
    @foreach($referrals as $referral)
    <tr>
      <td>
        <i class="fa fa-calendar text-danger"></i>
        <small>
          <em>
            {{date("jS M, Y",strtotime($referral->created_at))}}
          </em>
        </small>
      </td>
      <td>{{ $referral->email }}</td>
      <td>
          @if($referral->status=="new")
            <button class="btn btn-primary btn-sm btn-warning">Pending Contact</button>
          @elseif($referral->status=="not_interested")
            <button class="btn btn-primary btn-sm btn-danger">Not Interested</button>
          @else
            <button class="btn btn-primary btn-sm btn-success">Interested</button>
          @endif
      </td>
      <td>
          <a href="{{url('admin/referrals/'.$referral->id)}}" class="btn btn-default">
              <i class="fa fa-eye"></i>
          </a>
      </td>
    </tr>
    @endforeach
    @else
<tr>
<td colspan="5"><p><em>There are no referrals.</em></p></td>
</tr>
    @endif
  </tbody>
</table>

</div>
{!! $referrals->links() !!}
@endsection

@section('page_title')
 Referrals
@endsection