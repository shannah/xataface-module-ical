<?php
/**
 * @file actions/ica.php
 *
 * An action to produce a iCal feed for the current result set.
 *
 * @author Steve Hannah <shannah@sfu.ca>
 * @author Stephane Mourey <stephane.mourey@impossible-exil.info>
 * @created June. 6, 2014
 * @licence https://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License v2
 *
 * @defgroup actions
 * Some action info
 */

class actions_modules_ical_export {

	/**
	 * @ingroup actions
	 */
	function handle(&$params){
		import('modules/ical/xf/ical/IcalTool.php');
		$app =& Dataface_Application::getInstance();
		$ft = new xf_ical_IcalTool();


		$query = $app->getQuery();
		if ( @$query['-relationship'] ){
			$record =& $app->getRecord();
			$perms = $record->getPermissions(array('relationship'=>$query['-relationship']));
			if ( !@$perms['related records feed'] ) return Dataface_Error::permissionDenied('You don\'t have permission to view this relationship.');


		}

		$conf = $ft->getConfig();

		$query['-skip'] = 0;
		if ( !isset($query['-sort']) and !@$query['-relationship']){
			$table =& Dataface_Table::loadTable($query['-table']);
			$modifiedField = $table->getLastUpdatedField(true);
			if ( $modifiedField ){
				$query['-sort'] = $modifiedField.' desc';
			}
		}

		if ( !isset($query['-limit']) and !@$query['-relationship']){
			$default_limit = $conf['default_limit'];
			if ( !$default_limit ){
				$default_limit = 60;
			}
			$query['-limit'] = $default_limit;
		}

		if ( isset($query['--format']) ){
			$format = $query['--format'];
		} else {
			$format = 'ical';
		}
		echo $ft->getFeedIcal($query,$format);
		exit;
	}
}

?>