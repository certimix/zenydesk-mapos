<div id="content">
<!--start-top-serch-->
  <div id="content-header">
   <div></div>
      <div id="breadcrumb">
        <?php
        $formatBreadcrumb = function ($seg) {
            if (!$seg) return '';
            $s = strtolower($seg);
            if ($s === 'mapos') return 'ZenyDesk O.S';
            if ($s === 'os') return 'Ordens de Serviço';
            return ucfirst($seg);
        };
        ?>
        <a href="<?= base_url() ?>" title="Dashboard" class="tip-bottom"> Início</a>
        <?php if ($this->uri->segment(1) != null) { ?>
            <a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) ?>" class="tip-bottom" title="<?= $formatBreadcrumb($this->uri->segment(1)); ?>">
              <?= $formatBreadcrumb($this->uri->segment(1)); ?>
            </a>
          <?php if ($this->uri->segment(2) != null) { ?>
            <a href="<?= base_url() . 'index.php/' . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) ?>" class="current tip-bottom" title="<?= $formatBreadcrumb($this->uri->segment(2)); ?>">
              <?= $formatBreadcrumb($this->uri->segment(2)); ?>
            </a>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="container-flu">
      <div class="row-fluid">
        <div class="span12">
          <?php if ($var = $this->session->flashdata('success')): ?><script>swal("Sucesso!", "<?php echo str_replace('"', '', $var); ?>", "success");</script><?php endif; ?>
          <?php if ($var = $this->session->flashdata('error')): ?><script>swal("Falha!", "<?php echo str_replace('"', '', $var); ?>", "error");</script><?php endif; ?>
          <?php if (isset($view)) {
              echo $this->load->view($view, null, true);
          } ?>
        </div>
      </div>
    </div>
  </div>
