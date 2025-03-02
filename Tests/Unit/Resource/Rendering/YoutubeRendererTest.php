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

namespace AndrasOtto\Csp\Tests\Unit\Utility;

use AndrasOtto\Csp\Resource\Rendering\YouTubeRenderer;
use AndrasOtto\Csp\Service\ContentSecurityPolicyManager;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\YouTubeHelper;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class YoutubeRendererTest extends UnitTestCase
{

    /** @var YouTubeRenderer  */
    protected $subject;
    /**
     * Setup global
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockClass(YouTubeRenderer::class, ['getOnlineMediaHelper']);
        ContentSecurityPolicyManager::resetBuilder();
    }

    /**
     * @test
     */
    public function getPriorityReturnsTen()
    {
        self::assertEquals(10, $this->subject->getPriority());
    }

    /**
     * @test
     */
    public function rendersIframe()
    {
        $onlineMediaHelper = $this->getMockClass(YouTubeHelper::class, ['getOnlineMediaId'], ['youtube']);
        $onlineMediaHelper->expects(self::once())->method('getOnlineMediaId')->willReturn('test');
        $this->subject->expects(self::once())->method('getOnlineMediaHelper')->willReturn($onlineMediaHelper);

        $file = $this->getMockClass(File::class, [], [], '', false);

        $fileReference = $this->getMockClass(FileReference::class, ['getOriginalFile', 'getProperty'], [], '', false);
        $fileReference->expects(self::once())->method('getProperty')->willReturn('');
        $fileReference->expects(self::once())->method('getOriginalFile')->willReturn($file);
        $this->subject->render($fileReference, 100, 100);
        $header = ContentSecurityPolicyManager::getBuilder()->getHeader();
        self::assertEquals('frame-src www.youtube.com; child-src www.youtube.com;', $header['value']);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->subject);
    }
}
