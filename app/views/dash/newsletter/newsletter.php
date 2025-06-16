<style>
  .btn-admin-export {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background-color: #198754;
    /* Verde Bootstrap */
    color: #fff;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
    margin-left: 20px;
  }

  .btn-admin-export:hover {
    background-color: #157347;
    text-decoration: none;
  }

  .btn-admin-export i {
    font-size: 18px;
  }

  table,
  .modal-content,
  .form-control {
    text-transform: uppercase !important;
  }
</style>




<table class="table table-hover">
  <thead>
    <tr>
      


      <th scope="col">Email contato</th>
      <th scope="col">Data de envio</th>
      <th scope="col">Status contato</th>

    </tr>
  </thead>
  <tbody>

    <div class="mb-3" style="display: flex; align-items: center;">

      <a href="/newsletter/exportarNewsletterExcel"
        class="btn-admin-export"
        target="_blank">
        <i class='bx bx-file'></i> Exportar Excel
      </a>

    </div>
    <?php foreach ($listarEmails as $linha): ?>
      <tr>
     



        <td><?php echo htmlspecialchars($linha['email_newsletter']); ?></td>
        <td><?php echo htmlspecialchars($linha['data_inscricao_newsletter']); ?></td>




        <td>
          <?php echo ($linha['staus_newsletter']); ?>
        </td>



        </td>


      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script src="/vendors/dash/js/adminlte.js"></script>

</html>