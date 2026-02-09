# PC Hardware Domain Knowledge & Compatibility Rules

## Overview

This document contains the technical specifications, compatibility rules, and domain knowledge required for the TechStore AI platform's compatibility checker and AI recommendation system.

---

## Component Categories

### 1. CPU (Central Processing Unit)

**Key Specifications:**
- Socket Type (LGA1700, AM5, AM4, etc.)
- Core Count
- Thread Count
- Base Clock Speed (GHz)
- Boost Clock Speed (GHz)
- TDP (Thermal Design Power in Watts)
- Integrated Graphics (yes/no)
- Memory Support (DDR4/DDR5, max speed)
- Cache Size (L2, L3)

**Popular Sockets (2024-2026):**
```
Intel:
- LGA1700 (12th, 13th, 14th gen - Alder Lake, Raptor Lake, Meteor Lake)
- LGA1851 (15th gen - Arrow Lake) [upcoming]

AMD:
- AM5 (Ryzen 7000, 8000, 9000 series - DDR5 only)
- AM4 (Ryzen 5000, 3000 - DDR4 only) [legacy but popular]
```

**Example Products:**
```json
{
  "name": "Intel Core i7-13700K",
  "socket": "LGA1700",
  "cores": 16,
  "threads": 24,
  "base_clock": 3.4,
  "boost_clock": 5.4,
  "tdp": 125,
  "integrated_gpu": true,
  "memory_type": "DDR4/DDR5",
  "max_memory_speed": 5600
}
```

---

### 2. Motherboard

**Key Specifications:**
- Socket Type (must match CPU)
- Chipset (B650, Z790, etc.)
- Form Factor (ATX, mATX, Mini-ITX)
- Memory Slots (2, 4, 8)
- Memory Type Support (DDR4/DDR5)
- Max Memory Capacity (32GB, 128GB, etc.)
- PCIe Slots (x16, x8, x4, x1)
- M.2 Slots (number and generation)
- SATA Ports
- USB Ports (USB 3.2, USB-C, Thunderbolt)
- Networking (Ethernet speed, WiFi, Bluetooth)
- VRM Quality (for overclocking)

**Form Factors:**
```
ATX:        305mm x 244mm (most common, 7 expansion slots)
mATX:       244mm x 244mm (compact, 4 expansion slots)
Mini-ITX:   170mm x 170mm (smallest, 1 expansion slot)
E-ATX:      305mm x 330mm (extended, high-end)
```

**Chipset Hierarchy (Intel Z790 Example):**
```
Z790 > H770 > B760 > H610
- Z series: Overclocking support, most features
- H series: No overclocking, mid-range features
- B series: Business, balanced features
```

**Example Product:**
```json
{
  "name": "MSI MAG B650 TOMAHAWK WIFI",
  "socket": "AM5",
  "chipset": "B650",
  "form_factor": "ATX",
  "memory_slots": 4,
  "memory_type": "DDR5",
  "max_memory": 128,
  "pcie_slots": [
    {"type": "x16", "generation": 4},
    {"type": "x16", "generation": 3},
    {"type": "x1", "generation": 3}
  ],
  "m2_slots": 3,
  "sata_ports": 6
}
```

---

### 3. RAM (Memory)

**Key Specifications:**
- Memory Type (DDR4, DDR5)
- Speed (MHz) - e.g., 3200MHz, 6000MHz
- Capacity per stick (8GB, 16GB, 32GB)
- Total Kit Capacity
- CAS Latency (CL16, CL30, etc.)
- Voltage (1.2V, 1.35V)
- RGB Lighting (yes/no)
- Heat Spreader Design

**DDR Generations:**
```
DDR4:
- Speeds: 2133-3200MHz (JEDEC), 3600-4000MHz (OC)
- Voltage: 1.2V (standard), 1.35V (XMP)
- Common in AM4, LGA1200 platforms

DDR5:
- Speeds: 4800-5600MHz (JEDEC), 6000-7200MHz (XMP)
- Voltage: 1.1V (standard), 1.25-1.35V (XMP)
- Required for AM5, LGA1700 (some boards)
```

**Example Product:**
```json
{
  "name": "Corsair Vengeance RGB 32GB (2x16GB)",
  "type": "DDR5",
  "speed": 6000,
  "capacity_total": 32,
  "sticks": 2,
  "capacity_per_stick": 16,
  "cas_latency": 30,
  "voltage": 1.35,
  "rgb": true
}
```

---

### 4. GPU (Graphics Card)

**Key Specifications:**
- GPU Chip (RTX 4060, RX 7600, etc.)
- VRAM Capacity (8GB, 12GB, 16GB, 24GB)
- VRAM Type (GDDR6, GDDR6X)
- Base/Boost Clock
- TDP (Power Consumption)
- Power Connectors (8-pin, 12VHPWR)
- Physical Dimensions (Length, Width, Height)
- Slot Width (2-slot, 2.5-slot, 3-slot)
- Display Outputs (HDMI, DisplayPort count)
- Cooling Solution (air, hybrid, liquid)

**Power Connector Types:**
```
Legacy:
- 6-pin PCIe (75W)
- 8-pin PCIe (150W)
- 6+8 pin (225W)
- 8+8 pin (300W)

Modern (RTX 40 series):
- 12VHPWR (up to 600W)
```

**Example Product:**
```json
{
  "name": "MSI GeForce RTX 4060 Ti Gaming X 8GB",
  "chip": "RTX 4060 Ti",
  "vram": 8,
  "vram_type": "GDDR6",
  "base_clock": 2310,
  "boost_clock": 2610,
  "tdp": 160,
  "power_connector": "8-pin",
  "length_mm": 307,
  "width_mm": 140,
  "height_mm": 56,
  "slots": 2.5,
  "display_outputs": {
    "hdmi": 1,
    "displayport": 3
  }
}
```

---

### 5. PSU (Power Supply Unit)

**Key Specifications:**
- Wattage (550W, 750W, 1000W, etc.)
- Efficiency Rating (80+ Bronze, Gold, Platinum, Titanium)
- Modularity (Non-modular, Semi-modular, Fully-modular)
- Form Factor (ATX, SFX, SFX-L)
- 12VHPWR Support (for RTX 40 series)
- Rails (Single +12V rail vs Multi-rail)
- Protections (OVP, UVP, OCP, OTP, SCP)

**Efficiency Ratings:**
```
80+ Titanium: 94% @ 50% load
80+ Platinum: 92% @ 50% load
80+ Gold:     90% @ 50% load
80+ Bronze:   85% @ 50% load
```

**Example Product:**
```json
{
  "name": "Corsair RM750x 750W",
  "wattage": 750,
  "efficiency": "80_plus_gold",
  "modular": "fully_modular",
  "form_factor": "ATX",
  "pcie_8pin_connectors": 4,
  "sata_connectors": 9,
  "molex_connectors": 4,
  "warranty_years": 10
}
```

---

### 6. Storage

**Key Specifications:**
- Type (NVMe M.2, SATA SSD, HDD)
- Capacity (256GB, 512GB, 1TB, 2TB, etc.)
- Interface (PCIe Gen3/Gen4/Gen5, SATA III)
- Form Factor (M.2 2280, 2.5", 3.5")
- Read/Write Speed (MB/s)
- TBW (Terabytes Written - endurance)
- DRAM Cache (yes/no)

**Storage Hierarchy (Speed):**
```
1. PCIe Gen5 NVMe: ~12,000 MB/s read
2. PCIe Gen4 NVMe: ~7,000 MB/s read
3. PCIe Gen3 NVMe: ~3,500 MB/s read
4. SATA SSD:       ~550 MB/s read
5. HDD (7200rpm):  ~200 MB/s read
```

**Example Product:**
```json
{
  "name": "Samsung 980 PRO 1TB",
  "type": "NVMe",
  "interface": "PCIe_Gen4",
  "form_factor": "M.2_2280",
  "capacity_gb": 1000,
  "read_speed": 7000,
  "write_speed": 5000,
  "tbw": 600,
  "dram_cache": true
}
```

---

### 7. Case

**Key Specifications:**
- Form Factor Support (ATX, mATX, Mini-ITX)
- Max GPU Length (mm)
- Max CPU Cooler Height (mm)
- Max PSU Length (mm)
- Drive Bays (2.5", 3.5")
- Expansion Slots
- Front Panel I/O (USB, Audio)
- Included Fans
- Dust Filters
- Tempered Glass Panels

**Example Product:**
```json
{
  "name": "NZXT H510 Flow",
  "supports_form_factors": ["ATX", "mATX", "Mini-ITX"],
  "max_gpu_length": 381,
  "max_cpu_cooler_height": 165,
  "max_psu_length": 180,
  "drive_bays_25": 2,
  "drive_bays_35": 2,
  "expansion_slots": 7,
  "included_fans": 2,
  "usb_front": {
    "usb_a_3.0": 1,
    "usb_c": 1
  }
}
```

---

### 8. CPU Cooler

**Key Specifications:**
- Type (Air, AIO Liquid, Custom Loop)
- Socket Compatibility
- TDP Rating (Watts)
- Height (for air coolers)
- Radiator Size (for AIOs: 120mm, 240mm, 360mm)
- Fan Size (120mm, 140mm)
- Noise Level (dBA)

**Example Product:**
```json
{
  "name": "Noctua NH-D15",
  "type": "air",
  "sockets": ["LGA1700", "LGA1200", "AM5", "AM4"],
  "tdp_rating": 220,
  "height_mm": 165,
  "fans": 2,
  "fan_size": 140,
  "noise_level": 24.6
}
```

---

## Compatibility Rules

### Rule 1: CPU ↔ Motherboard
```python
def check_cpu_motherboard_compatibility(cpu, motherboard):
    """
    Critical Rule: CPU socket must exactly match motherboard socket
    """
    if cpu.socket != motherboard.socket:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"Socket mismatch: CPU requires {cpu.socket}, Motherboard has {motherboard.socket}"
        }
    
    # Additional checks
    issues = []
    
    # BIOS update warning for newer CPUs on older boards
    if requires_bios_update(cpu, motherboard):
        issues.append({
            "severity": "warning",
            "message": f"Motherboard may need BIOS update to support {cpu.name}"
        })
    
    # VRM quality check for high-TDP CPUs
    if cpu.tdp > 125 and motherboard.chipset in ['B560', 'B660', 'H610', 'B450']:
        issues.append({
            "severity": "warning",
            "message": f"Motherboard VRM may struggle with {cpu.tdp}W TDP. Consider higher-end chipset."
        })
    
    return {
        "compatible": True,
        "issues": issues
    }
```

### Rule 2: RAM ↔ Motherboard
```python
def check_ram_motherboard_compatibility(ram, motherboard):
    """
    Check RAM type, speed, and capacity compatibility
    """
    # Memory type must match
    if ram.type not in motherboard.memory_type:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"RAM type mismatch: Board supports {motherboard.memory_type}, RAM is {ram.type}"
        }
    
    # Check if total capacity exceeds motherboard max
    if ram.capacity_total > motherboard.max_memory:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"Total RAM ({ram.capacity_total}GB) exceeds motherboard max ({motherboard.max_memory}GB)"
        }
    
    # Check if RAM sticks fit in available slots
    if ram.sticks > motherboard.memory_slots:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"RAM kit has {ram.sticks} sticks, motherboard has only {motherboard.memory_slots} slots"
        }
    
    # Speed compatibility (warning only)
    issues = []
    if ram.speed > motherboard.max_memory_speed:
        issues.append({
            "severity": "warning",
            "message": f"RAM will run at {motherboard.max_memory_speed}MHz (board max), not {ram.speed}MHz"
        })
    
    return {
        "compatible": True,
        "issues": issues
    }
```

### Rule 3: GPU ↔ Case
```python
def check_gpu_case_compatibility(gpu, case):
    """
    Check if GPU physically fits in case
    """
    if gpu.length_mm > case.max_gpu_length:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"GPU too long: {gpu.length_mm}mm GPU, {case.max_gpu_length}mm case max"
        }
    
    # Slot width check
    if gpu.slots > 3:
        return {
            "compatible": False,
            "severity": "warning",
            "message": f"GPU is {gpu.slots}-slot design, may block adjacent PCIe slots"
        }
    
    return {"compatible": True}
```

### Rule 4: PSU Wattage Calculation
```python
def calculate_required_wattage(build_components):
    """
    Calculate total system wattage + 20% headroom
    """
    wattage = 0
    
    # CPU TDP
    wattage += build_components['cpu'].tdp
    
    # GPU TDP
    wattage += build_components['gpu'].tdp
    
    # Motherboard: ~50-80W
    wattage += 70
    
    # RAM: ~3-5W per stick
    wattage += build_components['ram'].sticks * 5
    
    # Storage: ~5W per NVMe, ~3W per SATA SSD, ~10W per HDD
    for storage in build_components.get('storage', []):
        if storage.type == 'NVMe':
            wattage += 5
        elif storage.type == 'SATA_SSD':
            wattage += 3
        elif storage.type == 'HDD':
            wattage += 10
    
    # Fans: ~2-5W each
    wattage += build_components.get('fans', 3) * 3
    
    # RGB: ~5-10W for full RGB setup
    if has_rgb(build_components):
        wattage += 10
    
    # Add 20% headroom
    recommended_wattage = wattage * 1.2
    
    return {
        "calculated_wattage": wattage,
        "recommended_minimum": recommended_wattage,
        "suggested_psu": find_next_psu_tier(recommended_wattage)
    }

def find_next_psu_tier(wattage):
    """Find appropriate PSU wattage tier"""
    tiers = [450, 550, 650, 750, 850, 1000, 1200, 1600]
    for tier in tiers:
        if tier >= wattage:
            return tier
    return 1600
```

### Rule 5: CPU Cooler Compatibility
```python
def check_cooler_compatibility(cpu, cooler, case, ram):
    """
    Check if cooler fits and can handle CPU
    """
    issues = []
    
    # Socket compatibility
    if cpu.socket not in cooler.sockets:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"Cooler doesn't support {cpu.socket} socket"
        }
    
    # TDP handling
    if cpu.tdp > cooler.tdp_rating:
        issues.append({
            "severity": "warning",
            "message": f"Cooler rated for {cooler.tdp_rating}W, CPU is {cpu.tdp}W. May run hot."
        })
    
    # Height clearance (air coolers)
    if cooler.type == 'air' and cooler.height_mm > case.max_cpu_cooler_height:
        return {
            "compatible": False,
            "severity": "critical",
            "message": f"Cooler height {cooler.height_mm}mm exceeds case limit {case.max_cpu_cooler_height}mm"
        }
    
    # RAM clearance (large air coolers)
    if cooler.type == 'air' and cooler.height_mm > 160 and ram.has_tall_heatspreader:
        issues.append({
            "severity": "warning",
            "message": "Large cooler may interfere with RAM heatspreaders. Verify clearance."
        })
    
    return {
        "compatible": True,
        "issues": issues
    }
```

---

## AI Recommendation Logic

### Budget Gaming Build Algorithm
```python
def recommend_gaming_build(budget_ils, games, preferences):
    """
    AI-powered gaming build recommendation
    """
    # Determine GPU budget allocation (40-50% for gaming)
    gpu_budget = budget_ils * 0.45
    
    # Select GPU first (most important for gaming)
    gpu = find_best_gpu_for_budget(gpu_budget, target_fps=preferences.get('fps', 60))
    
    # Calculate remaining budget
    remaining = budget_ils - gpu.price
    
    # CPU budget (20-25% of total)
    cpu_budget = budget_ils * 0.22
    cpu = find_balanced_cpu(cpu_budget, gpu_tier=gpu.tier)
    
    # Motherboard budget (10-12%)
    mobo_budget = budget_ils * 0.11
    mobo = find_motherboard(cpu.socket, mobo_budget, features=['wifi', 'm2_slots'])
    
    # RAM budget (8-10%)
    ram_budget = budget_ils * 0.09
    ram = recommend_ram(
        type=mobo.memory_type,
        capacity=16 if budget_ils < 5000 else 32,
        budget=ram_budget
    )
    
    # Storage budget (6-8%)
    storage_budget = budget_ils * 0.07
    storage = recommend_storage(
        budget=storage_budget,
        use_case='gaming',  # Prioritize NVMe for loading times
        min_capacity=500
    )
    
    # PSU budget (6-8%)
    required_wattage = calculate_required_wattage({
        'cpu': cpu,
        'gpu': gpu,
        'ram': ram
    })
    psu = find_psu(required_wattage['suggested_psu'], budget=budget_ils * 0.07)
    
    # Case budget (5-7%)
    case_budget = budget_ils * 0.06
    case = find_case(
        form_factor=mobo.form_factor,
        gpu_length=gpu.length_mm,
        budget=case_budget,
        preferences=preferences.get('aesthetics', {})
    )
    
    # Cooler budget (3-5%)
    cooler = find_cooler(cpu.tdp, cpu.socket, budget=budget_ils * 0.04)
    
    return {
        "build": {
            "cpu": cpu,
            "gpu": gpu,
            "motherboard": mobo,
            "ram": ram,
            "storage": storage,
            "psu": psu,
            "case": case,
            "cooler": cooler
        },
        "total_price": sum([c.price for c in build.values()]),
        "expected_performance": estimate_gaming_performance(cpu, gpu, ram),
        "upgrade_path": suggest_upgrade_path(build),
        "compatibility_score": 10.0
    }
```

---

## Common Build Profiles

### 1. Budget Gaming (2000-3000 ILS)
```yaml
Target Games: Fortnite, Valorant, League of Legends
Target FPS: 60+ on medium-high settings

Example Build:
  CPU: AMD Ryzen 5 5600 / Intel i5-12400F
  GPU: GTX 1660 Super / RTX 3050
  RAM: 16GB DDR4 3200MHz
  Storage: 512GB NVMe Gen3
  PSU: 550W 80+ Bronze
  Total: ~2,500 ILS
```

### 2. Mid-Range Gaming (4000-6000 ILS)
```yaml
Target Games: Cyberpunk 2077, Warzone, Elden Ring
Target FPS: 60+ on high, 144+ on competitive

Example Build:
  CPU: AMD Ryzen 5 7600 / Intel i5-13600K
  GPU: RTX 4060 Ti / RX 7600 XT
  RAM: 32GB DDR5 6000MHz
  Storage: 1TB NVMe Gen4
  PSU: 750W 80+ Gold
  Total: ~5,200 ILS
```

### 3. High-End Gaming (8000-12000 ILS)
```yaml
Target: 4K gaming, VR, streaming
Target FPS: 60+ at 4K, 144+ at 1440p

Example Build:
  CPU: AMD Ryzen 7 7800X3D / Intel i7-13700K
  GPU: RTX 4080 / RX 7900 XT
  RAM: 32GB DDR5 6400MHz CL30
  Storage: 2TB NVMe Gen4
  PSU: 850W 80+ Platinum
  Total: ~10,500 ILS
```

### 4. Workstation (Content Creation)
```yaml
Use Case: Video editing, 3D rendering, streaming

Example Build:
  CPU: AMD Ryzen 9 7950X / Intel i9-13900K (16+ cores)
  GPU: RTX 4070 / RX 7800 XT (CUDA/encoding)
  RAM: 64GB DDR5 5600MHz (4x16GB)
  Storage: 2TB NVMe Gen4 + 4TB SATA SSD
  PSU: 1000W 80+ Gold
  Total: ~12,000 ILS
```

---

## Palestinian Market Specifics

### Popular Brands in Palestine
```
Budget Tier:
- CPU: AMD Ryzen 5000 series (good value)
- GPU: Used GTX 1660 series (affordable)
- RAM: Team Group, Patriot

Mid-Range:
- CPU: Intel 12th/13th gen, Ryzen 7000
- GPU: RTX 4060/4060 Ti, RX 7600
- RAM: Corsair, Kingston Fury

High-End:
- All premium brands (ASUS ROG, MSI, Gigabyte AORUS)
```

### Pricing Patterns (Gaza Market)
```
GPU Markup: +15-25% vs US MSRP (due to import/taxes)
CPU Markup: +10-15%
RAM Markup: +20-30% (supply chain issues)
PSU Markup: +15-20%

Example:
- RTX 4060 Ti: $400 US → ~1,750 ILS in Gaza
- Ryzen 5 7600: $230 US → ~1,000 ILS in Gaza
```

### Common Customer Requests
1. "Gaming PC for Fortnite/PUBG under 3000 shekels"
2. "Cheapest build that can run Valorant at 144fps"
3. "PC for YouTube/video editing under 5000"
4. "Mining rig" (cryptocurrency interest)
5. "Office PC that can run some games" (dual purpose)

### Local Challenges
- **Power Outages**: Recommend UPS for expensive builds
- **Heat/Dust**: Gaza summers hot, recommend good cooling
- **Warranty Support**: Limited official support, local shops handle
- **Used Market**: Very active, AI should factor in used GPU prices

---

## Seasonal Trends

### Peak Buying Seasons (Palestine)
```
1. Ramadan/Eid (March-April): +30% sales
   - Kids get gift money, buy gaming PCs
   - Budget builds most popular

2. Summer (June-August): +25% sales
   - Students free, want to game
   - Mid-range builds popular

3. Back to School (September): +15% sales
   - "Study PCs" that can game
   - Office + light gaming builds

4. Winter Break (December-January): +20% sales
   - Holiday gifts, year-end bonuses
   - High-end builds increase
```

### Product Lifecycle
```
GPU New Releases:
- NVIDIA: September-October
- AMD: November-December
- Price drops on previous gen: -20% within 3 months

CPU New Releases:
- Intel: October
- AMD: January/July
- Previous gen remains competitive 12-18 months

RAM/Storage:
- Continuous price decline
- Major drops during Black Friday/Prime Day
```

---

## Integration with AI System

### Vector Embeddings Strategy
```python
# Store product specifications as embeddings
product_embedding = generate_embedding(
    text=f"""
    {product.name}
    Category: {product.category}
    Specifications: {json.dumps(product.specifications)}
    Use Cases: {product.common_use_cases}
    Compatibility: Socket {product.socket}, {product.memory_type} support
    Price Tier: {product.price_tier}
    """
)

# Query similar products
similar = vector_search(
    query_embedding=generate_embedding("gaming motherboard AM5 under 500"),
    filters={
        "category": "Motherboard",
        "socket": "AM5",
        "price_max": 500
    },
    limit=5
)
```

### Natural Language Processing
```python
# Extract intent from customer query
def parse_customer_query(query):
    """
    Examples:
    - "بدي جهاز للألعاب بـ 3000 شيكل" → budget=3000, use=gaming, language=ar
    - "i5 gaming motherboard under $150" → cpu_preference=i5, budget=150
    - "RTX 4060 compatible motherboard" → gpu=RTX4060, need=motherboard
    """
    
    intents = llm_extract_intent(query)
    
    return {
        "budget": intents.get('budget'),
        "use_case": intents.get('use_case'),  # gaming, workstation, office
        "target_games": intents.get('games', []),
        "preferences": {
            "brand": intents.get('brand_preference'),
            "rgb": intents.get('wants_rgb'),
            "quiet": intents.get('wants_quiet'),
        },
        "existing_components": intents.get('existing_parts', [])
    }
```

---

## Testing Dataset

### Sample Compatibility Tests
```yaml
Test Case 1: Perfect Match
  CPU: Ryzen 7 7800X3D (AM5, DDR5)
  Motherboard: MSI B650 TOMAHAWK (AM5, DDR5)
  RAM: 32GB DDR5 6000MHz
  Expected: PASS

Test Case 2: Socket Mismatch
  CPU: Intel i7-13700K (LGA1700)
  Motherboard: MSI B650 (AM5)
  Expected: FAIL - Socket incompatible

Test Case 3: Memory Type Mismatch
  CPU: Ryzen 5 5600 (AM4, DDR4 only)
  Motherboard: ASUS B550 (AM4, DDR4)
  RAM: 16GB DDR5
  Expected: FAIL - Board doesn't support DDR5

Test Case 4: Insufficient PSU
  GPU: RTX 4090 (450W TDP)
  CPU: i9-13900K (253W TDP)
  PSU: 650W
  Expected: FAIL - Need 1000W+ PSU

Test Case 5: GPU Too Long
  GPU: RTX 4080 (340mm)
  Case: NZXT H510 (325mm max)
  Expected: FAIL - GPU won't fit
```

---

This knowledge base should be continuously updated as new products are released and customer feedback is collected.
