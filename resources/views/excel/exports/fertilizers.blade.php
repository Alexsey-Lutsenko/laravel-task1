<table>
    <thead>
    <tr>
        <th>Наименование</th>
        <th>Норма Азот</th>
        <th>Норма Фосфор</th>
        <th>Норма Калий</th>
        <th>Культура ID</th>
        <th>Культура</th>
        <th>Регион</th>
        <th>Стоимость</th>
        <th>Описание</th>
        <th>Назначение</th>
    </tr>
    </thead>
    <tbody>
    @foreach($fertilizers as $fertilizer)
        <tr>
            <td>{{ $fertilizer->fertilizer }}</td>
            <td>{{ $fertilizer->normN }}</td>
            <td>{{ $fertilizer->normP }}</td>
            <td>{{ $fertilizer->normK }}</td>
            <td>{{ $fertilizer->culture_id }}</td>
            <td>{{ $fertilizer->culture->culture }}</td>
            <td>{{ $fertilizer->region }}</td>
            <td>{{ $fertilizer->price }}</td>
            <td>{{ $fertilizer->description }}</td>
            <td>{{ $fertilizer->purpose }}</td>
        </tr>
    @endforeach
    </tbody>
</table>