#!/usr/bin/env bash
./vendor/bin/phpunit --version
I=0
FLAG=0
for FILENAME in $(find tests/ -type f -name "*Test.php")
do
    printf '-'
    I=$(($I + 1))
    OUT=$(./vendor/bin/phpunit $FILENAME)
    if [ $? -ne 0 ]; then
        FLAG=$(($FLAG + 1))
        echo -e $OUT
    fi
done
printf "\n\n"
if [ $FLAG -eq 0 ]; then
    echo 'OK ('$I' files)'
else
    echo 'ERRORS!'
    echo 'Files: '$I', Errors: '$FLAG'.'
fi
exit $FLAG
