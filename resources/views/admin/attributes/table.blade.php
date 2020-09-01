<div class="table-responsive-sm">
    <table class="table table-striped" id="attributes-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Slug</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($attributes as $attribute)
            <tr>
                <td>{{ $attribute->name }}</td>
            <td>{{ $attribute->slug }}</td>
                <td>
                    {!! Form::open(['route' => ['admin.attributes.destroy', $attribute->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.attributes.show', [$attribute->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.attributes.edit', [$attribute->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>