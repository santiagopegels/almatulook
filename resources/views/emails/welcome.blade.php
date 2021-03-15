@component('mail::message')
# Te damos la bienvenida a {{ config('app.name') }} 👑

Gracias por formar parte.

@component('mail::button', ['url' => $loginUrl])
Volver a {{ config('app.name') }}
@endcomponent

Recordá que ante cualquier duda o consulta podes contactarnos:
* info@alamtulook.com
* instagram: almatulook

Saludos,<br>
{{ config('app.name') }}
@endcomponent
