<?php
$layout = 'admin';
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<div class="content">
    <h2>Používatelia</h2>
    <a href="<?= $link->url('admin.addUser') ?>" class="btn mybtn">Pridať používateľa</a>
    <button class="btn mybtn" onclick="toggleFilterOptions()">Filter</button>
    <div class="form-group" id="filterOptions" style="display: none;">
        <label for="filter">Filter:</label>
        <input class="form-control" type="text" id="filter" name="filter">

        <label for="filterColumn">Filtrovaný stĺpec:</label>
        <select class="form-control" id="filterColumn" name="filterColumn">
            <option value="name">Meno</option>
            <option value="surname">Priezvisko</option>
            <option value="username">Užívateľské meno</option>
            <option value="email">Email</option>
            <option value="role">Rola</option>
            <option value="address">Adresa</option>
        </select>

        <button class="btn mybtn" onclick="applyFilter()">Filtrovať</button>
        <button class="btn mybtn" onclick="clearFilter()">Zrušiť filter</button>
    </div>

    <div class="table-responsive">
        <table id="userTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Meno</th>
                <th>Priezvisko</th>
                <th>Užívateľské meno</th>
                <th>Email</th>
                <th>Adresa</th>
                <th>Rola</th>
                <th>Vymazať</th>
            </tr>
            </thead>
            <tbody>
            <?php $users = $data['users'];
            foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= $user->getName() ?></td>
                    <td><?= $user->getSurname() ?></td>
                    <td><?= $user->getUsername() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getAddress() ?></td>
                    <td><?= $user->getRole() ?></td>
                    <td><a href="<?= $link->url('user.delete', ['id' => $user->getId()]) ?>"
                           class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var config = {
        filteredItemsUrl: '<?= $link->url('user.filtered') ?>',
        allItemsUrl: '<?= $link->url('user.all') ?>'
    };
</script>

<script src="../../../public/js/filter.js"></script>
<script>
    function updateTable(users) {
        var tableBody = $('#userTable tbody');
        tableBody.empty();

        for (var i = 0; i < users.length; i++) {
            var user = users[i];
            var row = '<tr>' +
                '<td>' + user.id + '</td>' +
                '<td>' + user.name + '</td>' +
                '<td>' + user.surname + '</td>' +
                '<td>' + user.username + '</td>' +
                '<td>' + user.email + '</td>' +
                '<td>' + user.address + '</td>' +
                '<td>' + user.role + '</td>' +
                '<td><a href="<?= $link->url('user.delete', ['id' => '']) ?>/' + user.id +
                '" class="btn btn-outline-danger ms-3"><i class="bi bi-x-circle"></i></a></td>' +
                '</tr>';

            tableBody.append(row);
        }
    }
</script>