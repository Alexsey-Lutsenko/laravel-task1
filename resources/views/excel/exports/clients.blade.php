<table>
    <thead>
    <tr>
        <th>Наименование</th>
        <th>Дата договора</th>
        <th>Стоимость поставки</th>
        <th>Регион</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->client }}</td>
            <td>{{ date('d.m.Y', strtotime($client->created_at)) }}</td>
            <td>{{ $client->purchase }}</td>
            <td>{{ $client->region }}</td>
        </tr>
    @endforeach
    </tbody>
</table>