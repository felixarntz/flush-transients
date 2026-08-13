/**
 * WordPress dependencies
 */
import { test, expect } from '@wordpress/e2e-test-utils-playwright';

test.describe( 'Flush transients admin bar', () => {
	test( 'Admin bar item flushes transients and refreshes with success', async ( {
		page,
		admin,
	} ) => {
		await admin.visitAdminPage( 'index.php' );

		const flushItem = page.locator( '#wp-admin-bar-flush-transients > a' );
		await expect( flushItem ).toBeVisible();

		await flushItem.click();

		await page.waitForURL( /flush_transient_result=success/ );

		await expect( page.locator( '.notice-success' ) ).toContainText(
			'Transients flushed.'
		);
	} );
} );
