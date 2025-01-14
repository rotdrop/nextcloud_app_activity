<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2019 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Activity\Tests\Mock;

use OCP\Activity\IEvent;
use OCP\Activity\IProvider;

class Provider implements IProvider {
	/**
	 * @param string $language The language which should be used for translating, e.g. "en"
	 * @param IEvent $event The current event which should be parsed
	 * @param IEvent|null $previousEvent A potential previous event which you can combine with the current one.
	 *                                   To do so, simply use setChildEvent($previousEvent) after setting the
	 *                                   combined subject on the current event.
	 * @return IEvent
	 * @throws \InvalidArgumentException Should be thrown if your provider does not know this event
	 * @since 11.0.0
	 */
	public function parse($language, IEvent $event, IEvent $previousEvent = null): IEvent {
		if ($event->getApp() !== 'app1') {
			throw new \InvalidArgumentException();
		}

		switch ($event->getSubject()) {
			case 'subject1':
				$event->setParsedSubject(vsprintf('Subject1 #%1$s', $event->getSubjectParameters()));
				break;
			case 'subject2':
				$event->setParsedSubject(vsprintf('Subject2 @%2$s #%1$s', $event->getSubjectParameters()));
				break;
			case 'subject3':
				$event->setParsedSubject(vsprintf('Subject3 #%1$s @%2$s', $event->getSubjectParameters()));
				break;

			default:
				throw new \InvalidArgumentException();
		}

		return $event;
	}
}
