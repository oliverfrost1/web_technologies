import React from 'react';
import ReactDOM from 'react-dom';
import TestComponent from './KanbanBoard';

const root = document.getElementById('react-root');
if (root) {
    ReactDOM.createRoot(root).render(<TestComponent />);
}
