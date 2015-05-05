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

use Cake\Event\EventListenerInterface;

/**
 * Disqus Hook class.
 *
 */
class DisqusHook implements EventListenerInterface
{

    /**
     * {@inheritDoc}
     */
    public function implementedEvents()
    {
        return [
            'Plugin.Disqus.settingsDefaults' => 'settingsDefaults',
        ];
    }

    /**
     * Disqus plugin defaults settings values.
     *
     * @return array
     */
    public function settingsDefaults()
    {
        return [
            'disqus_shortname' => null,
        ];
    }
}