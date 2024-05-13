<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

function CheckUserCount() {

    $lastTime = COption::GetOptionString("main", "check_user_count_time");

    $currTime = new \Bitrix\Main\Type\DateTime();

    if (empty($lastTime)) {
        $lastTime = new \Bitrix\Main\Type\DateTime(0);
        $days = 0;
    }
    else {
        $lastTime = new \Bitrix\Main\Type\DateTime($lastTime);
        $days = ($currTime->getTimestamp() - $lastTime->getTimestamp()) / (24 * 60 *60);
    }

    $userOrm = CUser::GetList(
        "id",
        "asc",
        [
            'GROUPS_ID' => 1
        ]
    );

    $admins = [];
    while ($admin = $userOrm->Fetch()) {
        $admins[] = [
            'ID' => $admin['ID'],
            'EMAIL' => $admin['EMAIL']
        ];
    }

    $userOrm = CUser::GetList(
        "id",
        "asc",
        [
            'DATE_REGISTER_1' => $lastTime
        ],
        [
            'FIELDS' => [
                'ID'
            ]
        ]
    );

    $newUsers = [];
    while ($user = $userOrm->Fetch()) {
        $newUsers[] = $user['ID'];
    }

    CEvent::Send(
        'NEW_USER_COUNT',
        's1',
        [
            'EMAILS' => implode(',', array_column($admins, 'EMAIL')),
            'USER_COUNT' => count($newUsers),
            'DAYS' => $days
        ]
    );
    
    COption::SetOptionString("main", "check_user_count_time", $currTime->toString());

    return __FUNCTION__ . '();';
}