<div class="row-fluid">
    <div id="footer" class="span12" style="padding: 15px 10px; background: rgba(0,0,0,0.15); border-top: 1px solid rgba(255,255,255,0.08);">
        <div style="margin-bottom: 8px; display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; font-size: 13px;">
            <a href="https://zenydesk.com/#top" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">Início</a>
            <a href="https://zenydesk.com/#solucoes" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">Produtos</a>
            <a href="https://zenydesk.com/#solucoes" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">Serviços</a>
            <a href="https://zenydesk.com/#contato" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">Contato</a>
            <a href="https://zenydesk.com/#solucoes" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">Certificados</a>
            <a href="https://certimixx.com/" target="_blank" style="color: #e53e3e; text-decoration: none; font-weight: 600;">e-CNPJ para PMEs</a>
        </div>
        <div style="font-size: 11px; line-height: 1.6; color: #a0aec0; text-align: center;">
            <div><strong>Endereço:</strong> R. Salustiano Domingos de Santana, 268 - Centro, Paripiranga - BA, 48430-033</div>
            <div>
                <strong>Contato / WhatsApp:</strong>
                <a href="https://wa.me/5575998626311" target="_blank" style="color: #48bb78; text-decoration: none; font-weight: 500;">(75) 99896-2666 / (75) 99703-3317 / (75) 99949-6570</a> |
                <a href="https://wa.me/5575998626311" target="_blank" style="color: #48bb78; text-decoration: none; font-weight: 500;">Comercial: (75) 99862-6311</a>
            </div>
            <div>
                <strong>E-mails:</strong>
                <a href="mailto:atendimento@certimix.com.br" style="color: #cbd5e0;">atendimento@certimix.com.br</a> |
                <a href="mailto:financeiro@certimix.com.br" style="color: #cbd5e0;">financeiro@certimix.com.br</a> |
                <strong>Suporte:</strong> <a href="mailto:atendimento@certimix.com.br" style="color: #cbd5e0;">atendimento@certimix.com.br</a>
            </div>
            <div style="margin-top: 5px; opacity: 0.9;">
                &copy; <?= date('Y') ?> ZENYDESK. CNPJ: 35.624.635/0001-44. Todos os direitos reservados. Protegemos seus dados de acordo com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018).
            </div>
        </div>
    </div>
</div>
<!--end-Footer-part-->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/matrix.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        var dataTableEnabled = '<?= $configuration['control_datatable'] ?>';
        if(dataTableEnabled == '1') {
            $('#tabela').dataTable( {
                "pageLength": <?= $configuration['per_page'] ?>,
                "ordering": false,
                "info": false,
                "language": {
                    "url": "<?= base_url() ?>assets/js/dataTable_pt-br.json",
                },
                "oLanguage": {
                    "sSearch": "Pesquisa rápida na tabela abaixo:"
                }
            } );
        }
    } );
</script>
</html>
