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
namespace Disqus\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use QuickApps\Core\Plugin;

/**
 * Disqus Hook class.
 *
 */
class DisqusHook implements EventListenerInterface
{

    /**
     * Returns a list of hooks this Hook Listener is implementing. When the class is
     * registered in an event manager, each individual method will be associated with
     * the respective event.
     *
     * @return void
     */
    public function implementedEvents()
    {
        return [
            'CommentHelper.beforeRender' => 'disqus',
            'Plugin.Disqus.settingsDefaults' => 'settingsDefaults',
            'Alter.MenuHelper.render' => 'commentsNav',
        ];
    }

    /**
     * Renders Disqus's comments.
     *
     * @param \Cake\Event\Event $event The event that was triggered
     * @return string
     */
    public function disqus(Event $event)
    {
        $view = $event->subject();     
        if ($view->Comment->config('visibility') > 0) {
            $event->stopPropagation();
            $settings = Plugin::settings('Disqus');

            if (!empty($settings['disqus_shortname'])) {
                return $view->element('Disqus.js', ['settings' => $settings]);
            } else {
                return '<!-- Disqus plugin not configured -->';
            }
        }
    }

    public function commentsNav(Event $event, &$items, &$options)
    {
        if (count($items) == 5 &&
            $items[0]['title'] ==  __d('comment', 'All') &&
            $options['class'] == 'nav nav-pills'
        ) {
            $settings = Plugin::settings('Disqus');
            $items[] = [
                'title' => __d('disqus', 'Go to Disqus Moderation'),
                'url' => 'https://' . $settings['disqus_shortname'] . '.disqus.com/admin/moderate/',
                'target' => '_blank'
            ];
        }
    }

    public function settingsDefaults()
    {
        return [
            'disqus_shortname' => null,
        ];
    }
}
