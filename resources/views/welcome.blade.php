<!-- resources/views/rssfeed.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .description img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>News Articles</h1>

        <!-- Search and Sort Form -->
        <form method="GET" action="{{ url('/rssfeed') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="form-group mr-2">
                <select name="sort" class="form-control">
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="description" {{ request('sort') == 'description' ? 'selected' : '' }}>Description</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td class="description">{!! $item['description'] !!}</td>
                        <td><a href="{{ $item['link'] }}" target="_blank">Read more</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $data->appends(['search' => request('search'), 'sort' => request('sort')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</body>
</html>
