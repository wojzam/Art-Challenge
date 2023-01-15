<?php

require_once __DIR__ . '/../repository/SessionRepository.php';

class AppController
{
    protected $sessionRepository;
    private $request;

    public function __construct()
    {
        $this->sessionRepository = new SessionRepository();
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.php';
        $output = 'File not found';

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }

    protected function isAuthorized(): int
    {
        if (isset($_COOKIE["session_token"])) {
            $id_user = $this->sessionRepository->getUserId();
            if ($id_user) {
                return $id_user;
            } else {
                http_response_code(401);
                exit;
            }
        } else {
            http_response_code(401);
            exit;
        }
    }
}