<!-- Purchase Date Field -->
<div class="form-group">
    {!! Form::label('purchase_date', 'Purchase Date:') !!}
    <p>{{ $purchase->purchase_date }}</p>
</div>

<!-- Total Field -->
<div class="form-group">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $purchase->total }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $purchase->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $purchase->updated_at }}</p>
</div>

