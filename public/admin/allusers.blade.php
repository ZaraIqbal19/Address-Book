@extends('admin.adminlayout')
@section('admincontent')
<h3>All Users</h3>
<a href="/exporttoexcel" class="btn btn-success">Download Excel Report</a>
<a href="/generate-pdf" class="btn btn-success">Export to PDF</a>
<hr>
<div
    class="table-responsive"
>
    <table
        class="table table-striped"
    >
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">UserName</th>
                <th scope="col">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>{{$u->name}}</td>
                <td>{{$u->role}}</td>
                <td>
                   <form action="/updaterole/{{$u->id}}" method="post">
                    @csrf
                     <button type="submit" class="btn btn-info">Make Admin - Email</button>
                   </form>
                </td>
                <td>
                    <a href="https://api.whatsapp.com/send/?phone={{$u->phone}}&text=Dear+Abdul+Samad%2C%0A%0AThis+is+a+formal+notice+from+Aptech+Scheme+33+Center.+Our+records+show+that+you+were+absent+in+today%27s+class.+Kindly+explain+the+reason+for+your+absence.+We+expect+your+cooperation.%0A%0ARegards%2C%0AAptech+Scheme+33+Center&type=phone_number&app_absent=0" class="btn btn-info">Send Whatsapp Text</a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection