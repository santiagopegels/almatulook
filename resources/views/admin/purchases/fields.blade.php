<!-- Purchase Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('purchase_date', 'Purchase Date:') !!}
    {!! Form::text('purchase_date', null, ['class' => 'form-control','id'=>'purchase_date']) !!}
</div>

@push('scripts')
   <script type="text/javascript">
           $('#purchase_date').datetimepicker({
               format: 'YYYY-MM-DD HH:mm:ss',
               useCurrent: true,
               icons: {
                   up: "icon-arrow-up-circle icons font-2xl",
                   down: "icon-arrow-down-circle icons font-2xl"
               },
               sideBySide: true
           })
       </script>
@endpush


<!-- Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::number('total', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">Cancel</a>
</div>
