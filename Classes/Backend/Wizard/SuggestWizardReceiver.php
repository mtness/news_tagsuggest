<?php

declare(strict_types=1);

namespace GeorgRinger\NewsTagsuggest\Backend\Wizard;

/**
 * This file is part of the "news_tagsuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use GeorgRinger\NewsTagsuggest\Repository\SuggestRegistryRepository;
use TYPO3\CMS\Backend\Form\Wizard\SuggestWizardDefaultReceiver;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SuggestWizardReceiver extends SuggestWizardDefaultReceiver
{

    public function queryTable(array &$params, int $recursionCounter = 0): array
    {
        $rows = parent::queryTable($params, $recursionCounter);

        $searchString = strtolower((string)$params['value']);
        $matchRow = array_filter($rows, static function ($value) use ($searchString) {
            return strtolower((string)$value['label']) === $searchString;
        });

        if (empty($matchRow)) {
            $registry = $this->getSuggestRepository();

            $value = (string)$params['value'];
            $newUid = SuggestRegistryRepository::ID_PREFIX . $registry->set($value);
            $label = strip_tags(sprintf(
                $this->getLanguageService()->sL('LLL:EXT:news/Resources/Private/Language/locallang_be.xlf:tag_suggest'),
                $value
            ));

            $rows[$this->table . '_' . $newUid] = [
                'label' => $label,
                'title' => $label,
                'path' => '',
                'icon' => [
                    'identifier' => 'ext-news-tag',
                    'overlay' => null,
                ],
                'table' => $this->table,
                'uid' => $newUid,
            ];
        }

        return $rows;
    }

    private function getSuggestRepository(): SuggestRegistryRepository
    {
        return GeneralUtility::makeInstance(SuggestRegistryRepository::class);
    }
}
