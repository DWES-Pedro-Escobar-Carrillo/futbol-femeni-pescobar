<x-mail::message>
# Hola, {{ $arbitreName }}

A continuació tens el llistat dels propers partits on has estat assignat com a àrbitre principal:

<x-mail::table>
| Data i Hora | Local | Visitant | Estadi |
|:--- |:--- |:--- |:--- |
@foreach($partits as $partit)
| {{ $partit->data->format('d/m/Y H:i') }} | **{{ $partit->equipLocal->nom }}** | **{{ $partit->equipVisitant->nom }}** | {{ $partit->estadi->nom ?? 'Per determinar' }} |
@endforeach
</x-mail::table>

Recorda revisar l'acta després de cada partit.

Gràcies,<br>
{{ config('app.name') }}
</x-mail::message>