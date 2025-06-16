<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class NewsletterController extends Controller
{
    private $Newsletter;

    public function __construct()
    {


        $this->Newsletter = new Newsletter();
    }

    public function index()
    {
        $dados = array();



        $dados['nome'] = 'cheguei aqui';


        $this->carregarViews('contato', $dados);
    }

    public function enviarNewsletter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // resposta será em JSON
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if ($email) {
                $Newsletter = new Newsletter();
                $salvar = $Newsletter->salvarNewsletter($email);

                if (!$salvar) {
                    echo json_encode(['status' => 'erro', 'mensagem' => '⚠️ Este e-mail já está cadastrado!']);
                    exit;
                }

                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $phpmail = new PHPMailer\PHPMailer\PHPMailer();

                try {
                    $phpmail->isSMTP();
                    $phpmail->SMTPDebug = 0;
                    $phpmail->Host = HOTS_EMAIL;
                    $phpmail->Port = PORT_EMAIL;
                    $phpmail->SMTPSecure = 'ssl';
                    $phpmail->SMTPAuth = true;
                    $phpmail->Username = USER_EMAIL;
                    $phpmail->Password = PASS_EMAIL;
                    $phpmail->IsHTML(true);
                    $phpmail->setFrom(USER_EMAIL, '📢 Novo Inscrito - ONG Cultura Efatá');
                    $phpmail->addAddress(USER_EMAIL, 'ONG Cultura Efatá');

                    $phpmail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];

                    $phpmail->CharSet = 'UTF-8';
                    $phpmail->Encoding = 'base64';
                    $phpmail->Subject = '📩 Novo Inscrito na Newsletter da Cultura Efatá';
                    $phpmail->msgHTML("
                    <p><strong>Olá, equipe Efatá!</strong></p>
                    <p>Um novo inscrito se cadastrou na newsletter:</p>
                    <ul>
                        <li><strong>E-mail:</strong> <a href='mailto:$email'>$email</a></li>
                    </ul>
                    <p>É hora de espalhar ainda mais cultura e informação com amor e propósito!</p>
                    <p><strong>Equipe Web - Cultura Efatá</strong></p>");
                    $phpmail->AltBody = "Novo Inscrito na Newsletter da Cultura Efatá\n\nE-mail: $email";

                    $phpmail->send();

                    $phpmail->clearAddresses();
                    $phpmail->addAddress($email);
                    $phpmail->Subject = '💌 Bem-vindo à Newsletter da Cultura Efatá!';
                    $phpmail->msgHTML("
                    <div style='font-family: Arial, sans-serif; padding: 20px;'>
                        <h2 style='color: #009688;'>🌟 Bem-vindo à nossa jornada cultural!</h2>
                        <p>Olá,</p>
                        <p>Você acaba de se juntar à comunidade da <strong>Cultura Efatá</strong>! Agora você receberá:</p>
                        <ul>
                            <li>📆 Atualizações sobre oficinas e eventos culturais</li>
                            <li>📚 Projetos sociais e novidades da nossa ONG</li>
                            <li>🎨 Dicas de cultura, arte, música e inclusão</li>
                        </ul>
                        <p>💜 Obrigado por fazer parte desse movimento de transformação pela cultura!</p>
                        <p><strong>Equipe Cultura Efatá</strong></p>
                    </div>");
                    $phpmail->AltBody = "Olá,\n\nObrigado por se inscrever na Newsletter da ONG Cultura Efatá!";
                    $phpmail->send();

                    echo json_encode(['status' => 'sucesso', 'mensagem' => '✅ Inscrição confirmada! Em breve você receberá nossas novidades por e-mail.']);
                    exit;
                } catch (Exception $e) {
                    echo json_encode(['status' => 'erro', 'mensagem' => '❌ Ocorreu um erro ao processar sua inscrição.']);
                    exit;
                }
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => '⚠️ Por favor, insira um e-mail válido.']);
                exit;
            }
        }

        // Se não for POST
        echo json_encode(['status' => 'erro', 'mensagem' => '❌ Requisição inválida.']);
        exit;
    }

    public function contato_Newsletter()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $dados = array();
        $dados['listarEmails'] = $this->Newsletter->emails_Newsletter();
        $dados['conteudo'] = 'dash/newsletter/newsletter';

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function exportarNewsletterExcel()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica se o usuário está logado e é funcionário
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: /');
            exit;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        // Pegando os dados do banco
        $newsletterModel = new Newsletter();
        $emails = $newsletterModel->emails_Newsletter();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Newsletter');

        // Cabeçalho
        $sheet->setCellValue('A1', 'E-mail');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '43A047']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
        $sheet->getColumnDimension('A')->setAutoSize(true);

        // Dados
        $linha = 2;
        foreach ($emails as $item) {
            $sheet->setCellValue("A{$linha}", $item['email_newsletter']);
            $linha++;
        }

        // Borda e alinhamento dos dados
        $sheet->getStyle("A2:A" . ($linha - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Congelar o cabeçalho
        $sheet->freezePane('A2');

        // Headers do download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="newsletter_emails.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function totalNewsletter()
    {
        $Newsletter = new Newsletter();
        $total = $Newsletter->contarTodasNewsletter();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['total' => $total]);
    }
}
