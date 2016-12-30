<?php
declare(strict_types = 1);

namespace mheinzerling\simpleweb\router;


use mheinzerling\commons\StringUtils;

class SimpleRouter
{
    /**
     * @var string
     */
    private $contextPath;
    /**
     * @var string
     */
    private $request;
    /**
     * @var Page[]
     */
    private $resources = [];
    /**
     * @var Page[]
     */
    private $patterns = [];

    /**
     * SimpleRouter constructor.
     * @param string $contextPath
     * @param string|null $requestUri
     * @throws \Exception
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    function __construct(string $contextPath, string $requestUri = null)
    {
        $validContext = StringUtils::startsWith($contextPath, "/") && StringUtils::endsWith($contextPath, "/");
        if (!$validContext) throw new \Exception("Context must start and end with / .");
        $this->contextPath = $contextPath;
        if ($requestUri == null) $requestUri = $_SERVER["REQUEST_URI"];
        if (StringUtils::startsWith($requestUri, $contextPath)) $request = substr($requestUri, strlen($contextPath));
        else $request = $requestUri;
        $this->request = explode('?', $request, 2)[0];
    }

    public function add(string $resource, Page $page): void
    {
        $this->resources[$resource] = $page;
    }

    public function addPattern(string $pattern, $page): void
    {
        $this->patterns[$pattern] = $page;
    }

    /**
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function handle(): void
    {
        if (isset($this->resources[$this->request])) {
            $page = $this->resources[$this->request];
            if (!$page->accessAllowed()) throw new ForbiddenException($page);
            $page->render($this);
            return;
        }

        foreach ($this->patterns as $pattern => $page) {
            if (preg_match($pattern, $this->request)) {
                if (!$page->accessAllowed()) throw new ForbiddenException($page);
                $page->render($this);
                return;
            }
        }
        throw new NotFoundException($this->request);
    }

    function resource(string $resource): string
    {
        if ((StringUtils::startsWith($resource, "/"))) throw new \Exception("Relative resource path to context expected.");
        return $this->contextPath . $resource;
    }

    public function getRequest(): string
    {
        return $this->request;
    }


}