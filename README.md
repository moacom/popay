# popay

## 진행과정
- [0] $project['floors'] 사업자, 대리점


- 마이몰과 포인트몰에서 물건을 구매신청하면 처리해줄 관리자부분 제작

-- 포인트몰-적립금액필드(회원적립50%)

-- 관리자/회원관리/스마트홈쇼핑 복제

-- 포인트적립 - 마이몰과 포인트몰 적립비율은 같으나 대상이 틀림...


- $parents = get_parents(사업자아이디) 
- $target[0] = mb_id : 페이;
- $target[1] = mc_id : 가맹점;
- $target[0] = $parents[0];
- $target[0] = mb_id;

- $filter[pro]
- get_shares($point,$target, $filter){

return $data;	
}




- 마이몰과 포인트몰에서 물건을 구매할때 입금확인할때 처리해 주어야 하는부분
- 마이몰과 포인트몰에 쉐어해 줘야 하는 금액부분 
적립- 직접주문 부분테이블을 구분해 주기...

pointmal_list.php
