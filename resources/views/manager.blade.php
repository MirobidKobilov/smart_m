<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <div class="d-flex justify-content-around">
        <p>
            {{ Auth::user()->name }}
        </p>
        <a style="border: 1px solid black" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Topic</th>
          <th scope="col">Message</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($messages as $item)
        <form method="POST" action="{{ route('manager.post') }}">
            @csrf
            @method('PATCH')
            <tr class=" {{ $item->status == true ? 'mark_as_read' : '' }}">
                <td>{{ $item->id }}</td>
                <td>{{ $item->user_name }}</td>
                <td>{{ $item->user_email }}</td>
                <td>{{ $item->topic }}</td>
                <td>{{ $item->message }}</td>
                <td>
                  <div class="btn-group">
                    <input type="number" value="{{ $item->id }}" name="changed_id" class="d-none">
                    <button type="submit" class="btn btn-sm btn-outline-secondary {{ $item->status == true ? 'd-none' : '' }}">Mark as read</button>
                  </div>
                </td>
              </tr>
        </form>
        @endforeach
      </tbody>
    </table>
  </div>

  <style>
    .mark_as_read {
        background-color: greenyellow
    }
  </style>