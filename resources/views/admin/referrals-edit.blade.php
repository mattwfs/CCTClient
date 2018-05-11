@extends('layouts.admin')
@section('main-content')
  @if($referral->deleted_at)
  <div class="alert alert-danger">
    <strong>This referral was deleted.</strong>
  </div>
  @else
  <h2>Edit Referral</h2>
        @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif


          @if(Session::has('message'))
              <div class="alert alert-success">
                  <p><strong>{{session()->get('message')}}</strong></p>
              </div>
          @endif

  <form enctype="multipart/form-data" method="post" action="{{url('admin/referrals/update')}}" class="form">
      {!! csrf_field() !!}
      <input type="hidden" name="id" value="{{$referral->id}}"/>
      <table class="table table-bordered table-striped">
          <thead>
          <tr>
              <th>Date</th>
              <th>Email</th>
              <th>User</th>
              <th>Status</th>

          </tr>
          </thead>
          <tbody>

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
              <td>{{ ucfirst($referral->user->first_name) }} {{ ucfirst($referral->user->last_name) }}</td>
              <td>
                  <select style="width:100%;" name="referral_status" class="form-control select2-field" required>
                      <option value="new" @if($referral->status == "new") selected @endif>Pending Contact</option>
                      <option value="interested" @if($referral->status == "interested") selected @endif>Interested</option>
                      <option value="not_interested" @if($referral->status == "not_interested") selected @endif>Not Interested</option>
                  </select>
              </td>

          </tr>

          <tr><td colspan="3"><h4>Notes:</h4><br/><textarea class="form-control" name="referral_comment">{{$referral->notes}}</textarea></td></tr>
          <tr><td colspan="3"><div class="col-md-12 right">
                      <br/>
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                  </div></td></tr>

      </tbody>
      </table>
  </form>
    @endif


@endsection

@section('page_title')
Edit Referral
@endsection