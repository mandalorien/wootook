<?php

namespace WootookTest\Core\Database\Sql\Dml\Condition;

class ConditionTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Wootook\Core\Database\Adapter\Adapter
     */
    protected $_adapterMock = null;

    /**
     * @var \Wootook\Core\Database\Statement\Statement
     */
    protected $_statementMock = null;

    /**
     * @var \Wootook\Core\Database\Sql\Dml\DmlQuery
     */
    protected $_queryMock = null;

    /**
     * @var \Wootook\Core\Database\Sql\Dml\Condition\Condition
     */
    protected $_conditionMockClassName = null;

    public function setUp()
    {
        $this->_setUp();

        $this->_conditionMockClassName = 'Wootook\\Core\\Database\\Sql\\Dml\\Condition\\Condition';
    }

    protected function _setUp()
    {
        $this->_adapterMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Adapter\\Adapter');
        $this->_queryMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Dml\\DmlQuery', array($this->_adapterMock));
        $this->_statementMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Statement\\Statement', array($this->_adapterMock, $this->_queryMock));
    }

    protected function buildMock(Array $methods = array(), $callOriginalconstructor = true, $callOriginalClone = true)
    {
        return $this->getMockForAbstractClass($this->_conditionMockClassName, array(), '', $callOriginalconstructor, $callOriginalClone, true, $methods);
    }

    public function callNonPublicMethod($object, $method, Array $params = array())
    {
        $conditionMock = $this->buildMock();

        $method = new \ReflectionMethod(get_class($object), $method);
        $method->setAccessible(true);

        return $method->invokeArgs($conditionMock, $params);
    }

    public function testMagicToString()
    {
        $conditionMock = $this->buildMock(array('render'));
        $conditionMock->expects($this->once())
            ->method('render')
            ->will($this->returnValue('foo'))
        ;

        $this->assertInternalType('string', $conditionMock->__toString());
    }

    public function testMagicToStringWithRenderReturnsNull()
    {
        $conditionMock = $this->buildMock(array('render'));
        $conditionMock->expects($this->once())
            ->method('render')
            ->will($this->returnValue(null))
        ;

        $this->assertInternalType('string', $conditionMock->__toString());
    }

    public function testMagicToStringWithRenderReturnsInt()
    {
        $conditionMock = $this->buildMock(array('render'));
        $conditionMock->expects($this->once())
            ->method('render')
            ->will($this->returnValue(32))
        ;

        $this->assertInternalType('string', $conditionMock->__toString());
    }

    public function testMagicToStringWithRenderReturnsFloat()
    {
        $conditionMock = $this->buildMock(array('render'));
        $conditionMock->expects($this->once())
            ->method('render')
            ->will($this->returnValue(.1))
        ;

        $this->assertInternalType('string', $conditionMock->__toString());
    }

    public function testQueryAccessMethods()
    {
        $conditionMock = $this->buildMock();
        $adapter = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Adapter\\Adapter');
        $query = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Dml\\DmlQuery', array($adapter));

        $conditionMock->setQuery($query);

        $this->assertSame($query, $conditionMock->getQuery());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testSetQueryWithInvalidParameter()
    {
        $conditionMock = $this->buildMock();
        $conditionMock->setQuery('SELECT * FROM my_table');
    }

    public function testPlaceholderAssignment()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));

        $result = $this->callNonPublicMethod($conditionMock, '_getAllPlaceholders');
        $this->assertArrayHasKey(0, $result);
        $this->assertSame($placeholderMock, $result[0]);
    }

    public function testPlaceholderClearing()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));
        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));
        $this->callNonPublicMethod($conditionMock, '_clearPlaceholders');

        $expected = array();
        $this->assertEquals($expected, $this->callNonPublicMethod($conditionMock, '_getAllPlaceholders'));
    }

    public function testPlaceholderCallTrigger_beforePrepare()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $placeholderMock->expects($this->any())
            ->method('beforePrepare')
            ->with($this->_statementMock)
        ;

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));

        $conditionMock->beforePrepare($this->_statementMock);
    }

    public function testPlaceholderCallTrigger_afterPrepare()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $placeholderMock->expects($this->any())
            ->method('afterPrepare')
            ->with($this->_statementMock)
        ;

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));

        $conditionMock->afterPrepare($this->_statementMock);
    }

    public function testPlaceholderCallTrigger_beforeExecute()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $placeholderMock->expects($this->any())
            ->method('beforeExecute')
            ->with($this->_statementMock)
        ;

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));

        $conditionMock->beforeExecute($this->_statementMock);
    }

    public function testPlaceholderCallTrigger_afterExecute()
    {
        $conditionMock = $this->buildMock();
        $placeholderMock = $this->getMockForAbstractClass('Wootook\\Core\\Database\\Sql\\Placeholder\\Placeholder');

        $placeholderMock->expects($this->any())
            ->method('afterExecute')
            ->with($this->_statementMock)
        ;

        $this->callNonPublicMethod($conditionMock, '_addPlaceholder', array($placeholderMock));

        $conditionMock->afterExecute($this->_statementMock);
    }
}
