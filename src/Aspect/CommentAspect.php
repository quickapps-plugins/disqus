<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since    2.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Disqus\Aspect;

use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Before;
use QuickApps\Aspect\Aspect;

/**
 * Comment Aspect class.
 *
 */
class CommentAspect extends Aspect
{

    /**
     * This method will be called BEFORE "CommentHelper::render()".
     *
     * @param \Go\Aop\Intercept\MethodInvocation $invocation Invocation
     * @Around("execution(public Comment\View\Helper\CommentHelper->render(*))")
     */
    public function beforeCommentsRender(MethodInvocation $invocation)
    {
        $helper = $invocation->getThis();
        $view = $this->getProperty($helper, '_View');

        if ($helper->config('visibility') > 0) {
            $settings = plugin('Disqus')->settings;
            if (!empty($settings['disqus_shortname'])) {
                return $view->element('Disqus.js', ['settings' => $settings]);
            }
            return '<!-- Disqus plugin not configured -->';
        }

        return $invocation->proceed();
    }

    /**
     *
     * Adds a shortcut button to Comment's management submenu.
     *
     * @param \Go\Aop\Intercept\MethodInvocation $invocation Invocation
     * @Before("execution(public Menu\View\Helper\MenuHelper->render(*))")
     */
    public function commentsNav(MethodInvocation $invocation)
    {
        $helper = $invocation->getThis();
        $settings = plugin('Disqus')->settings;
        list($items, $options) = $invocation->getArguments();

        if (!empty($settings['disqus_shortname']) &&
            count($items) == 5 &&
            $items[0]['title'] ==  __d('comment', 'All')
        ) {
            $items[] = [
                'title' => __d('disqus', 'Go to Disqus Moderation'),
                'url' => 'https://' . $settings['disqus_shortname'] . '.disqus.com/admin/moderate/',
                'target' => '_blank'
            ];

            $this->setProperty($invocation, 'arguments', [$items, $options]);
        }
    }
}
