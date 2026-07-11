// State Management
const state = {
    currentView: 'dashboard',
    tco: {
        rate: 50,
        hours: 2,
        competitorBase: 6, // cheap VPS
        mosalamBase: 35 // Managed VPS
    }
};

// Navigation Function
function navigate(viewId) {
    // Update State
    state.currentView = viewId;

    // Hide all sections
    ['dashboard', 'competitors', 'strategy', 'pricing'].forEach(id => {
        document.getElementById(id).classList.add('hidden');
        document.getElementById('btn-' + id).classList.remove('active');
    });

    // Show selected
    document.getElementById(viewId).classList.remove('hidden');
    document.getElementById('btn-' + viewId).classList.add('active');

    // Trigger resize for charts to ensure they render correctly in new container
    window.dispatchEvent(new Event('resize'));

    // Play smooth growing animations when switching to Competitors Analysis tab
    if (viewId === 'competitors' && window.radarChartInstance) {
        window.radarChartInstance.reset();
        setTimeout(() => {
            window.radarChartInstance.update({
                duration: 1200,
                easing: 'easeOutQuart'
            });
        }, 60);
    }
}

// TCO Calculator Logic
function updateTCO() {
    const serviceType = document.getElementById('calc-service').value;
    const rate = parseFloat(document.getElementById('calc-rate').value) || 0;
    const hours = parseFloat(document.getElementById('calc-hours').value) || 0;
    
    document.getElementById('hours-display').innerText = hours + ' hrs';

    // Set Base Prices
    let compBase = 6;
    let mosalamBase = 35;

    if (serviceType === 'app') {
        compBase = 15;
        mosalamBase = 60;
    }

    // Calculations
    const hiddenCost = rate * hours;
    const totalComp = compBase + hiddenCost;
    const totalMosalam = mosalamBase;

    // DOM Updates
    document.getElementById('comp-base').innerText = compBase;
    document.getElementById('comp-hidden').innerText = hiddenCost;
    document.getElementById('comp-cost').innerText = '$' + totalComp.toFixed(2);
    document.getElementById('mosalam-cost').innerText = '$' + totalMosalam.toFixed(2);
    
    const savings = totalComp - totalMosalam;
    const savingsEl = document.getElementById('savings-display');
    
    if (savings >= 0) {
        savingsEl.parentElement.classList.remove('bg-error', 'text-white');
        savingsEl.parentElement.classList.add('bg-secondary', 'text-white');
        savingsEl.parentElement.innerHTML = `<strong>Savings:</strong> $${savings.toFixed(2)} / month`;
    } else {
        savingsEl.parentElement.classList.remove('bg-secondary', 'text-white');
        savingsEl.parentElement.classList.add('bg-error', 'text-white');
        savingsEl.parentElement.innerHTML = `<strong>Premium:</strong> You pay $${Math.abs(savings).toFixed(2)} extra for peace of mind.`;
    }
}

// Chart Initialization
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Market Chart (Bubble Chart)
    const ctxMarket = document.getElementById('marketChart').getContext('2d');
    new Chart(ctxMarket, {
        type: 'bubble',
        data: {
            datasets: [
                {
                    label: 'Budget Giants (Hostinger, Contabo)',
                    data: [{x: 20, y: 30, r: 20}],
                    backgroundColor: 'rgba(186, 26, 26, 0.6)', // Theme Error/Accent Red
                    borderColor: '#ba1a1a',
                    borderWidth: 1.5
                },
                {
                    label: 'Hyperscalers (AWS, Azure)',
                    data: [{x: 90, y: 80, r: 18}],
                    backgroundColor: 'rgba(115, 119, 127, 0.6)', // Theme Outline Grey
                    borderColor: '#73777f',
                    borderWidth: 1.5
                },
                {
                    label: 'Mosalam (The Void)',
                    data: [{x: 50, y: 75, r: 26}],
                    backgroundColor: 'rgba(25, 74, 228, 0.8)', // Theme Secondary Blue
                    borderColor: '#194ae4',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { 
                    min: 0, max: 100,
                    title: { display: true, text: 'Price / Complexity', font: { family: 'Inter', weight: 'bold' } },
                    grid: { display: false }
                },
                y: { 
                    min: 0, max: 100,
                    title: { display: true, text: 'Stability & Personal Support', font: { family: 'Inter', weight: 'bold' } },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Inter' } } }
            }
        }
    });

    // 2. Radar Chart (Competitor Matrix)
    const ctxRadar = document.getElementById('radarChart').getContext('2d');
    window.radarChartInstance = new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: ['Raw Performance', 'Price Predictability', 'Support Depth', 'Ease of Use', 'Resource Isolation'],
            datasets: [
                {
                    label: 'Mosalam.Com',
                    data: [75, 95, 90, 80, 85],
                    fill: true,
                    backgroundColor: 'rgba(25, 74, 228, 0.15)', // Secondary Blue overlay
                    borderColor: '#194ae4',
                    pointBackgroundColor: '#194ae4',
                    pointHoverBackgroundColor: '#194ae4',
                    borderWidth: 3
                },
                {
                    label: 'Contabo',
                    data: [85, 40, 20, 40, 30],
                    fill: true,
                    backgroundColor: 'rgba(0, 27, 53, 0.1)', // Primary Dark Navy overlay
                    borderColor: '#001b35',
                    pointBackgroundColor: '#001b35',
                    borderWidth: 2
                },
                {
                    label: 'Hostinger',
                    data: [50, 60, 40, 95, 50],
                    fill: true,
                    backgroundColor: 'rgba(107, 94, 43, 0.1)', // Tertiary overlay
                    borderColor: '#6b5e2b',
                    pointBackgroundColor: '#6b5e2b',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            scales: {
                r: {
                    angleLines: { display: true },
                    suggestedMin: 0,
                    suggestedMax: 100,
                    ticks: { font: { family: 'Inter' } },
                    pointLabels: { font: { family: 'Inter', weight: 'bold' } }
                }
            },
            plugins: {
                legend: { labels: { font: { family: 'Inter' } } }
            }
        }
    });

    // 3. Growth Chart (Cumulative Cost Line Chart)
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: ['Month 1', 'Month 6', 'Year 1', 'Year 1.5', 'Year 2'],
            datasets: [
                {
                    label: 'Mosalam Managed VPS',
                    data: [45, 270, 540, 810, 1080],
                    borderColor: '#194ae4', // Theme Secondary Blue
                    backgroundColor: '#194ae4',
                    tension: 0.1,
                    borderWidth: 3
                },
                {
                    label: 'Budget VPS + DIY Fixes',
                    data: [56, 186, 300, 600, 900], 
                    borderColor: '#ba1a1a', // Theme Error Red
                    backgroundColor: '#ba1a1a',
                    borderDash: [5, 5],
                    tension: 0.1,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    title: { display: true, text: 'Cumulative Cost ($)', font: { family: 'Inter', weight: 'bold' } }
                },
                x: {
                    ticks: { font: { family: 'Inter' } }
                }
            },
            plugins: {
                legend: { labels: { font: { family: 'Inter' } } },
                tooltip: {
                    callbacks: {
                        footer: (items) => {
                            if(items[0].datasetIndex === 1) return "Includes estimated 1hr/mo troubleshooting time.";
                            return "Zero troubleshooting time cost.";
                        }
                    }
                }
            }
        }
    });

    // Initialize TCO
    updateTCO();
});
