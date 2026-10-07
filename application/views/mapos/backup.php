<style>
    .backup-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .backup-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }
    .backup-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    .backup-icon-blue { background: rgba(15, 122, 222, 0.1); color: #0f7ade; }
    .backup-icon-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .backup-icon-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        text-decoration: none !important;
        border: none;
        cursor: pointer;
    }
</style>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box" style="padding: 20px;">
            <div class="widget-title" style="margin: -20px -20px 20px; padding: 10px 15px;">
                <span class="icon"><i class="bx bx-data"></i></span>
                <h5>Gestão de Banco de Dados, Backup & Migração</h5>
            </div>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <p style="color: #64748b; font-size: 14px; margin-bottom: 24px;">
                Gerencie com segurança os backups do ZenyDesk O.S, restaure dados de cópias de segurança ou faça o download do pacote de migração completo para transferir seu sistema para qualquer outro servidor de sua preferência.
            </p>

            <div class="row-fluid">
                <!-- Card 1: Download de Backup SQL -->
                <div class="span4">
                    <div class="backup-card">
                        <div class="backup-icon backup-icon-blue">
                            <i class='bx bx-download'></i>
                        </div>
                        <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #0f172a;">1. Exportar / Download SQL</h4>
                        <p style="color: #64748b; font-size: 13px; min-height: 50px;">
                            Baixe uma cópia completa em arquivo SQL de todas as tabelas, clientes, ordens de serviço, produtos e configurações.
                        </p>
                        <a href="<?= site_url('backup/download'); ?>" class="btn-action btn-primary" style="background-color: #0f7ade; color: white;">
                            <i class='bx bx-download'></i> Baixar Backup SQL
                        </a>
                    </div>
                </div>

                <!-- Card 2: Restauração / Upload SQL -->
                <div class="span4">
                    <div class="backup-card">
                        <div class="backup-icon backup-icon-green">
                            <i class='bx bx-upload'></i>
                        </div>
                        <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #0f172a;">2. Importar / Restaurar SQL</h4>
                        <p style="color: #64748b; font-size: 13px; min-height: 50px;">
                            Faça o upload de um arquivo SQL de backup para restaurar o banco de dados da sua empresa.
                        </p>
                        <form action="<?= site_url('backup/restaurar'); ?>" method="post" enctype="multipart/form-data" style="margin: 0;">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div style="margin-bottom: 12px;">
                                <input type="file" name="userfile" accept=".sql,.txt" required style="font-size: 12px;">
                            </div>
                            <button type="submit" class="btn-action btn-success" style="background-color: #10b981; color: white;">
                                <i class='bx bx-upload'></i> Restaurar Banco
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Card 3: Transferência / Migração para Outro Servidor -->
                <div class="span4">
                    <div class="backup-card">
                        <div class="backup-icon backup-icon-purple">
                            <i class='bx bx-transfer-alt'></i>
                        </div>
                        <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #0f172a;">3. Pacote de Migração ZIP</h4>
                        <p style="color: #64748b; font-size: 13px; min-height: 50px;">
                            Gere um pacote compactado completo (ZIP) com o banco de dados e o manifesto de migração para levar o site para outro domínio.
                        </p>
                        <a href="<?= site_url('backup/transferir'); ?>" class="btn-action btn-secondary" style="background-color: #8b5cf6; color: white;">
                            <i class='bx bx-export'></i> Baixar Pacote de Migração
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
