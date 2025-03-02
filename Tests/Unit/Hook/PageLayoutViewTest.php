<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace AndrasOtto\Csp\Tests\Unit\Hook;

use AndrasOtto\Csp\Hooks\PageLayoutView;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class PageLayoutViewTest extends UnitTestCase
{

    /** @var PageLayoutView */
    protected $subject;

    /** @var \TYPO3\CMS\Backend\View\PageLayoutView */
    protected $pageView;

    /**
     * Setup global
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subject = new PageLayoutView();
        $this->pageView = new \TYPO3\CMS\Backend\View\PageLayoutView();
    }

    protected function getFlexFormConfig()
    {
        $row['list_type'] = 'csp_iframeplugin';
        $row['pi_flexform'] = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="main">
            <language index="lDEF">
                <field index="settings.iframe.src">
                    <value index="vDEF">https://www.google.de</value>
                </field>
                <field index="settings.iframe.name">
                    <value index="vDEF">test</value>
                </field>
                <field index="settings.iframe.sandbox">
                    <value index="vDEF">allow-popups-to-escape-sandbox,allow-scripts,allow-top-navigation,allow-presentation,allow-popups,allow-pointer-lock,allow-modals,allow-forms,allow-orientation-lock</value>
                </field>
                <field index="settings.iframe.allowFullScreen">
                    <value index="vDEF">1</value>
                </field>
                <field index="settings.iframe.allowPaymentRequest">
                    <value index="vDEF">1</value>
                </field>
                <field index="settings.iframe.dataAttributes">
                    <value index="vDEF">test: test1</value>
                </field>
            </language>
        </sheet>
        <sheet index="stlye">
            <language index="lDEF">
                <field index="settings.iframe.class">
                    <value index="vDEF">test test2</value>
                </field>
                <field index="settings.iframe.width">
                    <value index="vDEF">100</value>
                </field>
                <field index="settings.iframe.height">
                    <value index="vDEF">50</value>
                </field>
            </language>
        </sheet>
        <sheet index="style">
            <language index="lDEF">
                <field index="settings.iframe.class">
                    <value index="vDEF"></value>
                </field>
                <field index="settings.iframe.width">
                    <value index="vDEF">0</value>
                </field>
                <field index="settings.iframe.height">
                    <value index="vDEF">0</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';
        return $row;
    }

    /**
     * @test
     */
    public function preProcessFunctionCanBeCalled()
    {
        $null = null;
        $emptyArray = [];
        $this->subject->preProcess($this->pageView, $null, $null, $null, $emptyArray);
    }

    /**
     * @test
     */
    public function iframePreviewHeaderContentCanBeGenerated()
    {
        $null = null;
        $headerContent = '';
        $config = $this->getFlexFormConfig();

        $this->subject->preProcess($this->pageView, $null, $headerContent, $null, $config);
        self::assertEquals('<b>Iframe</b><br>', $headerContent);
    }
    /**
     * @test
     */
    public function iframePreviewItemContentCanBeGenerated()
    {
        $null = null;
        $itemContent = '';
        $config = $this->getFlexFormConfig();

        $this->subject->preProcess($this->pageView, $null, $null, $itemContent, $config);
        self::assertEquals(
            '<br><b>src: </b><i>https://www.google.de</i><br><b>name: </b><i>test</i><br><b>sandbox: </b><i>allow-popups-to-escape-sandbox,allow-scripts,allow-top-navigation,allow-presentation,allow-popups,allow-pointer-lock,allow-modals,allow-forms,allow-orientation-lock</i><br><b>allowFullScreen: </b><i>1</i><br><b>allowPaymentRequest: </b><i>1</i><br><b>dataAttributes: </b><i>test: test1</i><br><b>class: </b><i></i><br><b>width: </b><i>0</i><br><b>height: </b><i>0</i>',
            $itemContent
        );
    }

    /**
     * @test
     */
    public function dataAttributeCanBeGenerated()
    {
        $null = null;
        $itemContent = '';
        $config['list_type'] = 'csp_iframeplugin';
        $config['pi_flexform'] = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3FlexForms>
    <data>
        <sheet index="main">
            <language index="lDEF">
                <field index="settings.iframe.dataAttributes">
                    <value index="vDEF">&lt;b&gt;a&lt;d&gt;value</value>
                </field>
            </language>
        </sheet>
    </data>
</T3FlexForms>';

        $this->subject->preProcess($this->pageView, $null, $null, $itemContent, $config);
        self::assertEquals(
            '<br><b>dataAttributes: </b><i>&lt;b&gt;a&lt;d&gt;value</i><br><span class="form-group has-error"><label class="t3js-formengine-label"></label><b>Error: </b>Name should be a valid xml name, must not start with "xml" and semicolons are not allowed, "<b>a<d>value" given</span>',
            $itemContent
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}
